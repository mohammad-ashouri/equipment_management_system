<?php

namespace Database\Seeders\DataSeeders;

use App\Models\Catalogs\Category;
use App\Models\Catalogs\DocumentType;
use App\Models\Picture;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class Posts extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function extractImageLinks($content)
    {
        $htmlContent = $content;

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);

        $dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//a[img]');

        $imageLinks = [];

        foreach ($nodes as $node) {
            $a_href = $node->getAttribute('href');
            $img = $node->getElementsByTagName('img')->item(0);
            if ($img) {
                $img_src = $img->getAttribute('src');
                if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $a_href) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $img_src)) {
                    $imageLinks[] = [
//                        'a_href' => str_replace('https://ofull.ir/wp-content/uploads/', '/storage/old_images/', $a_href),
//                        'img_src' => str_replace('https://ofull.ir/wp-content/uploads/', '/storage/old_images/', $img_src)
                        'a_href' => $a_href,
//                        'img_src' => $img_src
                    ];
                    $node->parentNode->removeChild($node);
                }
            }
        }

        $bodyContent = '';
        $body = $dom->getElementsByTagName('body')->item(0);
        if ($body) {
            foreach ($body->childNodes as $childNode) {
                $bodyContent .= $dom->saveHTML($childNode);
            }
        } else {
            $bodyContent = $dom->saveHTML();
        }

        $cleanedHtml = html_entity_decode($bodyContent, ENT_QUOTES, 'UTF-8');

        $cleanedHtmlWithBreaks = nl2br($cleanedHtml);

        return response()->json([
            'imageLinks' => $imageLinks,
            'cleanedHtml' => $cleanedHtmlWithBreaks
        ]);
    }

    public function convertToDate($input_str)
    {
        $date = \DateTime::createFromFormat('Ymd', $input_str);

        if ($date !== false) {
            return $date->format('Y-m-d');
        } else {
            return $input_str;
        }
    }

    public function run(): void
    {
        ini_set('memory_limit', '-1');
        $of_posts = DB::connection('mysql2')->table('of_posts')->where('post_type', 'post')->where(function ($query) {
            $query->where('post_status', 'publish');
            $query->orWhere('post_status', 'draft');
        })->get();
        foreach ($of_posts as $of_post) {
            if ($of_post->post_content == null) {
                continue;
            }
            $cleanedHtml = $this->extractImageLinks($of_post->post_content)->original['cleanedHtml'];
            if (empty($cleanedHtml)) {
                $cleanedHtml = null;
            }

            //Import pictures
            $postAttachments = DB::connection('mysql2')->table('of_posts')->where('post_parent', $of_post->ID)->where('post_type', 'attachment')->get();
            $src = '-';
            foreach ($postAttachments as $postAttachment) {
                $isChild = true;
                $src = '-';
                $mainImage = DB::connection('mysql2')->table('of_postmeta')->where('post_id', $of_post->ID)->where('meta_key', '=', '_thumbnail_id')->first();

                if (!empty($mainImage) and $mainImage != null) {
                    $mainImageSrc = DB::connection('mysql2')->table('of_posts')->where('ID', $mainImage->meta_value)->pluck('guid')->first();

                    if ($postAttachment->guid == $mainImageSrc) {
                        $isChild = false;
                        $src = str_replace('https://ofull.ir/wp-content/uploads/', '/storage/old_images/', $mainImageSrc);
                        $src = str_replace('https://usdoc.ir/wp-content/uploads/', '/storage/old_images/', $src);
                    } else {
                        $src = str_replace('https://usdoc.ir/wp-content/uploads/', '/storage/old_images/', $postAttachment->guid);
                        $src = str_replace('https://ofull.ir/wp-content/uploads/', '/storage/old_images/', $src);
                    }
                }
                if ($src != '-' and !empty($src)) {
                    $picture = new Picture();
                    $picture->post_id = $of_post->ID;
                    $picture->post_type = "post";
                    if (!$isChild) {
                        $imageType = 'picture_main';
                    } else {
                        $imageType = 'picture_child';
                    }
                    $picture->image_type = $imageType;
                    $picture->src = $src;
                    $picture->adder = $postAttachment->post_author;
                    $picture->created_at = $postAttachment->post_date;
                    $picture->save();
                }
            }

            if ($src == '-' or empty($src)) {
                $imageLinks = $this->extractImageLinks($of_post->post_content)->original['imageLinks'];
                foreach ($imageLinks as $imageLink) {
                    $picture = new Picture();
                    $picture->post_id = $of_post->ID;
                    $picture->post_type = "post";
                    $picture->image_type = 'picture_child';
                    $src = str_replace('https://usdoc.ir/wp-content/uploads/', '/storage/old_images/', $imageLink['a_href']);
                    $src = str_replace('https://ofull.ir/wp-content/uploads/', '/storage/old_images/', $src);
                    $picture->src = $src;
                    $picture->adder = $postAttachment->post_author;
                    $picture->created_at = $postAttachment->post_date;
                    $picture->save();
                }
            }
            $mainImage = DB::connection('mysql2')
                ->table('of_posts')
                ->where('post_title', $of_post->post_title)
                ->where('post_type', '=', 'attachment')
                ->first();
            if (!empty($mainImage)) {
                Picture::where('post_id', $of_post->ID)->where('post_type', 'post')->update(['image_type' => 'picture_child']);
                $attachFile = DB::connection('mysql2')->table('of_postmeta')->where('post_id', $mainImage->ID)->where('meta_key', '_wp_attached_file')->first();
                $picture = new Picture();
                $picture->post_id = $of_post->ID;
                $picture->post_type = "post";
                $picture->image_type = 'picture_main';
                $picture->src = '/storage/old_images/' . $attachFile->meta_value;
                $picture->adder = $of_post->post_author;
                $picture->created_at = $of_post->post_date;
                $picture->save();
            }

            $of_postmeta = DB::connection('mysql2')->table('of_postmeta')->where('post_id', $of_post->ID)->get()->toArray();

            $personAndOrganization = $locations = $events = $times = $equipments = $contracts = $other = $mainSubject = $secondSubject = $thirdSubject = $fourthSubject =
            $sourceBook = $volumeNumber = $bookNumber = $pageNumber = $documentNumber = $documentInternalNumber = $documentType = $documentProducer = $RecipientOfDocument =
            $ADDate = $jalaliDate = $description = null;
            foreach ($of_postmeta as $of_postmeta_item) {
                switch ($of_postmeta_item->meta_key) {
                    case 'اشخاص-و-ارگان ها':
                        $personAndOrganization = $of_postmeta_item->meta_value;
                        if (empty($personAndOrganization)) {
                            $personAndOrganization = null;
                        }
                        break;
                    case 'مکان_ها':
                        $locations = $of_postmeta_item->meta_value;
                        if (empty($locations)) {
                            $locations = null;
                        }
                        break;
                    case 'اتفاقات_و_حوادث_و_وقایع':
                        $events = $of_postmeta_item->meta_value;
                        if (empty($events)) {
                            $events = null;
                        }
                        break;
                    case 'زمان_ها':
                        $times = $of_postmeta_item->meta_value;
                        if (empty($times)) {
                            $times = null;
                        }
                        break;
                    case 'تجهیزات':
                        $equipments = $of_postmeta_item->meta_value;
                        if (empty($equipments)) {
                            $equipments = null;
                        }
                        break;
                    case 'تعارف_و_قراردادها':
                        $contracts = $of_postmeta_item->meta_value;
                        if (empty($contracts)) {
                            $contracts = null;
                        }
                        break;
                    case 'متفرقه':
                        $other = $of_postmeta_item->meta_value;
                        if (empty($other)) {
                            $other = null;
                        }
                        break;
                    case 'موضوع-اصلی':
                        $mainSubject = $of_postmeta_item->meta_value;
                        if (empty($mainSubject)) {
                            $mainSubject = null;
                        }
                        break;
                    case 'موضوع_دوم':
                        $secondSubject = $of_postmeta_item->meta_value;
                        if (empty($secondSubject)) {
                            $secondSubject = null;
                        }
                        break;
                    case 'موضوع_سوم':
                        $thirdSubject = $of_postmeta_item->meta_value;
                        if (empty($thirdSubject)) {
                            $thirdSubject = null;
                        }
                        break;
                    case 'موضوع_چهارم':
                        $fourthSubject = $of_postmeta_item->meta_value;
                        if (empty($fourthSubject)) {
                            $fourthSubject = null;
                        }
                        break;
                    case 'منبع__کتاب_':
                        $sourceBook = $of_postmeta_item->meta_value;
                        if (empty($sourceBook)) {
                            $sourceBook = null;
                        }
                        break;
                    case 'شماره_جلد':
                        $volumeNumber = $of_postmeta_item->meta_value;
                        if (empty($volumeNumber)) {
                            $volumeNumber = null;
                        }
                        break;
                    case 'شماره_کتاب':
                        $bookNumber = $of_postmeta_item->meta_value;
                        if (empty($bookNumber)) {
                            $bookNumber = null;
                        }
                        break;
                    case 'شماره_صفحه':
                        $pageNumber = $of_postmeta_item->meta_value;
                        if (empty($pageNumber)) {
                            $pageNumber = null;
                        }
                        break;
                    case 'شماره_سند':
                        $documentNumber = $of_postmeta_item->meta_value;
                        if (empty($documentNumber)) {
                            $documentNumber = null;
                        }
                        break;
                    case 'شماره_داخلی_سند':
                        $documentInternalNumber = $of_postmeta_item->meta_value;
                        if (empty($documentInternalNumber)) {
                            $documentInternalNumber = null;
                        }
                        break;
                    case 'نوع_سند':
                        $documentType = $of_postmeta_item->meta_value;
                        if (empty($documentType)) {
                            $documentType = null;
                        }
                        break;
                    case 'تهیه_کننده_سند':
                        $documentProducer = $of_postmeta_item->meta_value;
                        if (empty($documentProducer)) {
                            $documentProducer = null;
                        }
                        break;
                    case 'گیرنده_سند':
                        $RecipientOfDocument = $of_postmeta_item->meta_value;
                        if (empty($RecipientOfDocument)) {
                            $RecipientOfDocument = null;
                        }
                        break;
                    case 'تاریخ_میلادی':
                        $ADDate = $of_postmeta_item->meta_value;
                        if (empty($ADDate)) {
                            $ADDate = null;
                        }
                        break;
                    case 'تاریخ شمسی':
                        $jalaliDate = $of_postmeta_item->meta_value;
                        if (empty($jalaliDate)) {
                            $jalaliDate = null;
                        }
                        break;
                    case 'توضیحات':
                        $description = $of_postmeta_item->meta_value;
                        if (empty($description)) {
                            $description = null;
                        }
                        break;
                }
            }

            if (empty($documentType)) {
                $documentType = '-';
            }
            $documentType = DocumentType::firstOrCreate(['name' => $documentType, 'adder' => 10]);

            $post = new Post();
            $post->id = $of_post->ID;
            $post->title = $of_post->post_title;
            $post->body = $cleanedHtml;

            $personAndOrganization = explode('-', $personAndOrganization);
            $personAndOrganization = array_map(function ($item) {
                $item = trim($item);
                $item = str_replace(['"', '،'], '-', $item);
                return $item;
            }, $personAndOrganization);
            $personAndOrganization = array_filter($personAndOrganization);
            $personAndOrganization = array_unique($personAndOrganization);
            $trimmedAndFiltered = implode('-', $personAndOrganization);
            $trimmedAndFiltered = trim($trimmedAndFiltered);
            if (empty($trimmedAndFiltered)) {
                $trimmedAndFiltered = null;
            }
            if (!empty($trimmedAndFiltered)) {
                $filtered = [];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $post->person_and_organization = $trimmedAndFiltered;

            $locations = explode('-', $locations);
            $locations = array_map(function ($item) {
                $item = trim($item);
                $item = str_replace(['"', '،'], '-', $item);
                return $item;
            }, $locations);
            $locations = array_filter($locations);
            $locations = array_unique($locations);
            $trimmedAndFiltered = implode('-', $locations);
            $trimmedAndFiltered = trim($trimmedAndFiltered);
            if (empty($trimmedAndFiltered)) {
                $trimmedAndFiltered = null;
            }
            if (!empty($trimmedAndFiltered)) {
                $filtered = [];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $post->locations = $trimmedAndFiltered;

            $events = explode('-', $events);
            $events = array_map(function ($item) {
                $item = trim($item);
                $item = str_replace(['"', '،'], '-', $item);
                return $item;
            }, $events);
            $events = array_filter($events);
            $events = array_unique($events);
            $trimmedAndFiltered = implode('-', $events);
            $trimmedAndFiltered = trim($trimmedAndFiltered);
            if (empty($trimmedAndFiltered)) {
                $trimmedAndFiltered = null;
            }
            if (!empty($trimmedAndFiltered)) {
                $filtered = [];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $post->events = $trimmedAndFiltered;

            $times = explode('-', $times);
            $times = array_map(function ($item) {
                $item = trim($item);
                $item = str_replace(['"', '،'], '-', $item);
                return $item;
            }, $times);
            $times = array_filter($times);
            $times = array_unique($times);
            $trimmedAndFiltered = implode('-', $times);
            $trimmedAndFiltered = trim($trimmedAndFiltered);
            if (empty($trimmedAndFiltered)) {
                $trimmedAndFiltered = null;
            }
            if (!empty($trimmedAndFiltered)) {
                $filtered = [];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $post->times = $trimmedAndFiltered;

            $equipments = explode('-', $equipments);
            $equipments = array_map(function ($item) {
                $item = trim($item);
                $item = str_replace(['"', '،'], '-', $item);
                return $item;
            }, $equipments);
            $equipments = array_filter($equipments);
            $equipments = array_unique($equipments);
            $trimmedAndFiltered = implode('-', $equipments);
            $trimmedAndFiltered = trim($trimmedAndFiltered);
            if (empty($trimmedAndFiltered)) {
                $trimmedAndFiltered = null;
            }
            if (!empty($trimmedAndFiltered)) {
                $filtered = [];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $post->equipments = $trimmedAndFiltered;

            $contracts = explode('-', $contracts);
            $contracts = array_map(function ($item) {
                $item = trim($item);
                $item = str_replace(['"', '،'], '-', $item);
                return $item;
            }, $contracts);
            $contracts = array_filter($contracts);
            $contracts = array_unique($contracts);
            $trimmedAndFiltered = implode('-', $contracts);
            $trimmedAndFiltered = trim($trimmedAndFiltered);
            if (empty($trimmedAndFiltered)) {
                $trimmedAndFiltered = null;
            }
            if (!empty($trimmedAndFiltered)) {
                $filtered = [];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $post->contracts = $trimmedAndFiltered;

            $other = explode('-', $other);
            $other = array_map(function ($item) {
                $item = trim($item);
                $item = str_replace(['"', '،'], '-', $item);
                return $item;
            }, $other);
            $other = array_filter($other);
            $other = array_unique($other);
            $trimmedAndFiltered = implode('-', $other);
            $trimmedAndFiltered = trim($trimmedAndFiltered);
            if (empty($trimmedAndFiltered)) {
                $trimmedAndFiltered = null;
            }
            if (!empty($trimmedAndFiltered)) {
                $filtered = [];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $post->other = $trimmedAndFiltered;

            $post->main_subject = $mainSubject;
            $post->second_subject = $secondSubject;
            $post->third_subject = $thirdSubject;
            $post->fourth_subject = $fourthSubject;
            $post->source_book = $sourceBook;
            $post->volume_number = $volumeNumber;
            $post->book_number = $bookNumber;
            $post->page_number = $pageNumber;
            $post->document_number = $documentNumber;
            $post->document_internal_number = $documentInternalNumber;
            $post->document_type = $documentType->id;
            $post->document_producer = $documentProducer;
            $post->recipient_of_document = $RecipientOfDocument;
            $post->AD_date = $this->convertToDate($ADDate);
            if (empty($jalaliDate)) {
                $post->jalali_date = Jalalian::fromCarbon(Carbon::parse($post->AD_date))->format('Y-m-d');
            } else {
                $post->jalali_date = $jalaliDate;
            }
            $post->description = $description;

            switch ($of_post->post_status) {
                case 'publish':
                    $status = 1;
                    break;
                case 'draft':
                    $status = 2;
                    break;
            }
            $post->status = $status;
            $post->adder = $of_post->post_author;
            $post->created_at = $of_post->post_date;
            $post->updated_at = $of_post->post_modified;
            $post->save();
        }
        Category::whereId(4124)->update(['category_type' => 'international_document']);
    }
}

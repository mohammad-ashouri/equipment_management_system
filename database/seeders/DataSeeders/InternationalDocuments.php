<?php

namespace Database\Seeders\DataSeeders;

use App\Models\InternationalDocument;
use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternationalDocuments extends Seeder
{
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

    public function run(): void
    {
        ini_set('memory_limit', '-1');
        $of_posts = DB::connection('mysql2')->table('of_posts')->where('post_type', '-')->where(function ($query) {
            $query->where('post_status', 'publish');
            $query->orWhere('post_status', 'draft');
        })->get();
        foreach ($of_posts as $of_post) {
            if($of_post->post_content==null){
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
                    $picture->post_type = "international_document";
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
                    $picture->post_type = "international_document";
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
                Picture::where('post_id', $of_post->ID)->where('post_type', 'international_document')->update(['image_type' => 'picture_child']);
                $attachFile=DB::connection('mysql2')->table('of_postmeta')->where('post_id',$mainImage->ID)->where('meta_key','_wp_attached_file')->first();
                $picture = new Picture();
                $picture->post_id = $of_post->ID;
                $picture->post_type = "international_document";
                $picture->image_type = 'picture_main';
                $picture->src = '/storage/old_images/' . $attachFile->meta_value;
                $picture->adder = $of_post->post_author;
                $picture->created_at = $of_post->post_date;
                $picture->save();
            }

            $of_postmeta = DB::connection('mysql2')->table('of_postmeta')->where('post_id', $of_post->ID)->get()->toArray();

            $personAndOrganization = $locations = $events = $times = $equipments = $contracts = $other = null;
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
                }
            }

            $internationalDocument = new InternationalDocument();
            $internationalDocument->id = $of_post->ID;
            $internationalDocument->title = $of_post->post_title;
            $internationalDocument->body = $cleanedHtml;

            if (!empty($personAndOrganization)) {
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
                $internationalDocument->person_and_organization = $trimmedAndFiltered;
            }

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
                $filtered=[];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $internationalDocument->locations = $trimmedAndFiltered;

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
                $filtered=[];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $internationalDocument->events = $trimmedAndFiltered;

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
                $filtered=[];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $internationalDocument->times = $trimmedAndFiltered;

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
                $filtered=[];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $internationalDocument->equipments = $trimmedAndFiltered;

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
                $filtered=[];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $internationalDocument->contracts = $trimmedAndFiltered;

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
                $filtered=[];
                foreach (explode('-', $trimmedAndFiltered) as $item) {
                    $filtered[] = trim($item);
                }
                $trimmedAndFiltered = implode('-', $filtered);
            }
            $internationalDocument->other = $trimmedAndFiltered;

            switch ($of_post->post_status) {
                case 'publish':
                    $status = 1;
                    break;
                case 'draft':
                    $status = 2;
                    break;
            }
            $internationalDocument->status = $status;
            $internationalDocument->adder = $of_post->post_author;
            $internationalDocument->created_at = $of_post->post_date;
            $internationalDocument->updated_at = $of_post->post_modified;
            $internationalDocument->save();
        }
    }
}

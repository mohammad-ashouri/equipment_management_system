<?php

namespace Database\Seeders\DataSeeders;

use App\Models\BookIntroduction;
use App\Models\Catalogs\DocumentType;
use App\Models\Picture;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookIntroductions extends Seeder
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

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        $of_posts = DB::connection('mysql2')->table('of_posts')->where('post_type', 'books')->where(function ($query) {
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
                    $picture->post_type = "book_introductions";
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
                    $picture->post_type = "book_introductions";
                    $picture->image_type = 'picture_child';
                    $src = str_replace('https://usdoc.ir/wp-content/uploads/', '/storage/old_images/', $imageLink['a_href']);
                    $src = str_replace('https://ofull.ir/wp-content/uploads/', '/storage/old_images/', $src);
                    $picture->src = $src;
                    $picture->adder = $postAttachment->post_author;
                    $picture->created_at = $postAttachment->post_date;
                    $picture->save();
                }
            }

            $of_postmeta = DB::connection('mysql2')->table('of_postmeta')->where('post_id', $of_post->ID)->get()->toArray();

            $bookTitle = $author = $publisher = $subjects = $hint = null;
            foreach ($of_postmeta as $of_postmeta_item) {
                switch ($of_postmeta_item->meta_key) {
                    case 'title':
                        $bookTitle = $of_postmeta_item->meta_value;
                        if (empty($bookTitle)) {
                            $bookTitle = null;
                        }
                        break;
                    case 'author':
                        $author = $of_postmeta_item->meta_value;
                        if (empty($author)) {
                            $author = null;
                        }
                        break;
                    case 'publisher':
                        $publisher = $of_postmeta_item->meta_value;
                        if (empty($publisher)) {
                            $publisher = null;
                        }
                        break;
                    case 'subjects':
                        $subjects = $of_postmeta_item->meta_value;
                        if (empty($subjects)) {
                            $subjects = null;
                        }
                        break;
                    case 'اشاره':
                        $hint = $of_postmeta_item->meta_value;
                        if (empty($hint)) {
                            $hint = null;
                        }
                        break;
                }
            }

            $bookIntroduction = new BookIntroduction();
            $bookIntroduction->id = $of_post->ID;
            $bookIntroduction->title = $of_post->post_title;
            $bookIntroduction->body = $cleanedHtml;

            $bookIntroduction->book_title = $bookTitle;
            $bookIntroduction->author = $author;
            $bookIntroduction->publisher = $publisher;
            $bookIntroduction->subjects = $subjects;
            $bookIntroduction->hint = $hint;

            switch ($of_post->post_status) {
                case 'publish':
                    $status = 1;
                    break;
                case 'draft':
                    $status = 2;
                    break;
            }
            $bookIntroduction->status = $status;
            $bookIntroduction->adder = $of_post->post_author;
            $bookIntroduction->created_at = $of_post->post_date;
            $bookIntroduction->updated_at = $of_post->post_modified;
            $bookIntroduction->save();
        }
    }
}

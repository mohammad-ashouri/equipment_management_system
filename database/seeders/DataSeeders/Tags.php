<?php

namespace Database\Seeders\DataSeeders;

use App\Models\Post;
use App\Models\TagLabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tags extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        $posts = Post::get();
        foreach ($posts as $post) {
            $of_tags = DB::connection('mysql2')->table('of_term_relationships')->where('object_id', $post->id)
                ->join('of_term_taxonomy', 'of_term_relationships.term_taxonomy_id', '=', 'of_term_taxonomy.term_taxonomy_id')
                ->join('of_terms', 'of_term_taxonomy.term_id', '=', 'of_terms.term_id')
                ->where('of_term_taxonomy.taxonomy', 'post_tag')
                ->select('of_terms.term_id', 'of_terms.name')
                ->get();

            $tags = [];
            foreach ($of_tags as $of_tag) {
                $tagId = TagLabel::firstOrCreate(['name' => $of_tag->name, 'adder' => 10])->id;
                $tags[] = $tagId;
            }
            $post = Post::find($post->id);
            $post->tags = json_encode($tags, true);
            $post->save();
        }
    }
}

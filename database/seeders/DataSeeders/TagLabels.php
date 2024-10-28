<?php

namespace Database\Seeders\DataSeeders;

use App\Models\TagLabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagLabels extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        $of_tags = DB::connection('mysql2')->table('of_term_taxonomy')->where('taxonomy', 'post_tag')->get();
        foreach ($of_tags as $of_tag) {
            $of_tag_label = DB::connection('mysql2')->table('of_terms')->where('term_id', $of_tag->term_id)->first();
            $tag = new TagLabel();
            $tag->name = $of_tag_label->name;
            $tag->adder = 10;
            $tag->save();
        }
    }
}

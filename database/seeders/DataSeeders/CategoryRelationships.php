<?php

namespace Database\Seeders\DataSeeders;

use App\Models\Catalogs\Category;
use App\Models\CategoryRelationship;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryRelationships extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        $of_categories = DB::connection('mysql2')->table('of_term_relationships')
            ->join('of_term_taxonomy', 'of_term_taxonomy.term_taxonomy_id', '=', 'of_term_relationships.term_taxonomy_id')
            ->join('of_terms', 'of_terms.term_id', '=', 'of_term_taxonomy.term_id')
            ->where('taxonomy', 'category')->get();
        foreach ($of_categories as $of_category) {
            $category = Category::firstOrCreate(['id' => $of_category->term_id, 'name' => $of_category->name, 'parent' => $of_category->parent, 'category_type' => 'post', 'adder' => 10]);
            $relationship = new CategoryRelationship();
            $relationship->type = 'post';
            $relationship->post_id = $of_category->object_id;
            $relationship->category_id = $category->id;
            $relationship->save();
        }
        $of_categories = DB::connection('mysql2')->table('of_term_relationships')
            ->join('of_term_taxonomy', 'of_term_taxonomy.term_taxonomy_id', '=', 'of_term_relationships.term_taxonomy_id')
            ->join('of_terms', 'of_terms.term_id', '=', 'of_term_taxonomy.term_id')
            ->where('taxonomy', 'dastebandi')
            ->where('parent', 0)
            ->get();
        foreach ($of_categories as $of_category) {
            switch ($of_category->name){
                case 'اساتید':
                case 'مستند':
                case 'معرفی کتاب':
                case 'سوژه های پژوهشی':
                    continue 2;
                default:
                    if ($of_category->parent == 0) {
                        $of_category->parent = 4124;
                    }
                    $category = Category::firstOrCreate(['id' => $of_category->term_id, 'name' => $of_category->name, 'parent' => $of_category->parent, 'category_type' => 'international_document', 'adder' => 10]);
                    $relationship = new CategoryRelationship();
                    $relationship->type = 'international_document';
                    $relationship->post_id = $of_category->object_id;
                    $relationship->category_id = $category->id;
                    $relationship->save();
            }

        }
    }
}

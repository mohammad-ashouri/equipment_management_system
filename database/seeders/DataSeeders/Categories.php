<?php

namespace Database\Seeders\DataSeeders;

use App\Models\Catalogs\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        $of_categories = DB::connection('mysql2')->table('of_term_taxonomy')
            ->join('of_terms', 'of_terms.term_id', '=', 'of_term_taxonomy.term_id')
            ->where('taxonomy', 'category')->get();
        foreach ($of_categories as $of_category) {
            $category = new Category();
            $category->name = $of_category->name;
            $category->parent = $of_category->parent;
            $category->category_type = 'post';
            $category->adder = 10;
            $category->save();
        }
    }
}

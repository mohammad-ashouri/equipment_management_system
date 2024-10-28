<?php

namespace Database\Seeders\DataSeeders;

use App\Models\Catalogs\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Sections extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create(
            ['name'=>'دیپلم','adder'=>10],
            ['name'=>'کارشناسی','adder'=>10],
            ['name'=>'کارشناسی ارشد','adder'=>10],
            ['name'=>'دکتری','adder'=>10],
            ['name'=>'عمومی','adder'=>10],
            ['name'=>'فوق دکتری','adder'=>10],
            ['name'=>'سطح یک حوزوی','adder'=>10],
            ['name'=>'سطح دو حوزوی','adder'=>10],
            ['name'=>'سطح سه حوزوی','adder'=>10],
            ['name'=>'سطح چهار حوزوی','adder'=>10],
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\Catalogs\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShenakhtDefaultValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create default buildings
        Building::insert([
            ['name' => 'قم - پردیسان', 'adder' => 1],
            ['name' => 'قم - هنرستان', 'adder' => 1],
            ['name' => 'قم - شهید اخلاقی', 'adder' => 1],
        ]);
    }
}

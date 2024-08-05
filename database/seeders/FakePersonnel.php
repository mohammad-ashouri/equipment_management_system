<?php

namespace Database\Seeders;

use App\Models\Personnel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakePersonnel extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Personnel::factory(20)->create();
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
//            PermissionsSeeder::class,
//            CategoryRelationships::class,
//            Sections::class,
//            BookIntroductions::class,
//            SocialMedia::class,
//            Professors::class,
//            ResearchSubjects::class,
//            Documentaries::class,
//            InternationalDocuments::class,
//            Posts::class,
//            TagLabels::class,
//            Tags::class,
            ContactUsPermissionsSeeder::class
        ]);

    }
}

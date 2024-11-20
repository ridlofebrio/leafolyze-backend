<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UserDetailSeeder::class,
            DiseasesSeeder::class,
            ShopsSeeder::class,
            ProductsSeeder::class,
            ArticlesSeeder::class,
            TomatoLeafDetectionsSeeder::class,
            DetectionDiseaseSeeder::class,
        ]);
    }
}

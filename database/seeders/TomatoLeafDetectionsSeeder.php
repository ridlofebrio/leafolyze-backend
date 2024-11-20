<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TomatoLeafDetectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tomato_leaf_detections')->insert([
            [
                'gambarUrl' => 'https://example.com/image1.jpg',
                'user_id' => 1,
                'description' => 'Detected multiple diseases.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gambarUrl' => 'https://example.com/image2.jpg',
                'user_id' => 2,
                'description' => 'Healthy leaf.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

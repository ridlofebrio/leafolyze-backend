<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetectionDiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detection_disease')->insert([
            [
                'detection_id' => 1,
                'disease_id' => 1, // Bacterial Spot
            ],
            [
                'detection_id' => 1,
                'disease_id' => 2, // Early Blight
            ],
            [
                'detection_id' => 2,
                'disease_id' => 3, // Healthy
            ],
        ]);
    }
}

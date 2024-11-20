<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;

class DiseasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diseases = [
            'Black Spot',
            'Bacterial Spot',
            'Early Blight',
            'Late Blight',
            'Leaf Mold',
            'Septoria Leaf',
            'Yellow Leaf',
        ];

        foreach ($diseases as $disease) {
            Disease::create(['name' => $disease]);
        }
    }
}

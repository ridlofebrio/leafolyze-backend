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
            [
                'name' => 'Black Spot',
                'description' => 'A fungal disease that causes dark, circular spots on leaves. The spots may have yellow halos and cause leaves to yellow and drop prematurely.'
            ],
            [
                'name' => 'Bacterial Spot',
                'description' => 'A bacterial infection causing small, dark brown spots on leaves, stems and fruit. Spots may have yellow halos and cause defoliation.'
            ],
            [
                'name' => 'Early Blight',
                'description' => 'A fungal disease causing dark brown spots with concentric rings on older leaves first. Can cause severe defoliation and reduced yields.'
            ],
            [
                'name' => 'Late Blight',
                'description' => 'A devastating fungal disease causing large, dark brown patches on leaves and stems. Can destroy entire plants within days in wet conditions.'
            ],
            [
                'name' => 'Leaf Mold',
                'description' => 'A fungal disease causing pale green to yellow spots on upper leaf surfaces and olive-green to gray fuzzy growth on undersides.'
            ],
            [
                'name' => 'Septoria Leaf',
                'description' => 'A fungal disease causing small circular spots with dark borders and light centers. Usually starts on lower leaves and can cause severe defoliation.'
            ],
            [
                'name' => 'Yellow Leaf',
                'description' => 'A viral disease causing leaves to turn yellow, curl, and become brittle. Plants may be stunted and produce fewer fruits.'
            ],
        ];

        foreach ($diseases as $disease) {
            Disease::create($disease);
        }
    }
}
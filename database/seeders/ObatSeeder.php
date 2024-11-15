<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Obat::create([
            'gambarUrl' => 'https://awsimages.detik.net.id/community/media/visual/2021/10/20/manfaat-jamu-kelor-3_169.jpeg?w=1200',
            'name' => 'Obat Bacterial Spot',
            'user_id' => 3,
            'description' => 'Obat ini digunakan untuk mengobati penyakit Bacterial Spot pada tanaman.',
            'price' => '50000',
            'type' => 'Bacterial Spot',
        ]);

        Obat::create([
            'gambarUrl' => 'https://awsimages.detik.net.id/community/media/visual/2021/10/20/manfaat-jamu-kelor-3_169.jpeg?w=1200',
            'name' => 'Obat Early Blight',
            'user_id' => 3,
            'description' => 'Obat ini digunakan untuk mengobati penyakit Early Blight pada tanaman.',
            'price' => '45000',
            'type' => 'Early Blight',
        ]);

        Obat::create([
            'gambarUrl' => 'https://awsimages.detik.net.id/community/media/visual/2021/10/20/manfaat-jamu-kelor-3_169.jpeg?w=1200',
            'name' => 'Obat Healthy',
            'user_id' => 3,
            'description' => 'Obat ini untuk menjaga kesehatan tanaman agar tetap sehat.',
            'price' => '55000',
            'type' => 'Healthy',
        ]);
    }
}

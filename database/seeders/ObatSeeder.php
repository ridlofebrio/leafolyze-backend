<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'gambarUrl' => 'https://awsimages.detik.net.id/community/media/visual/2021/10/20/manfaat-jamu-kelor-3_169.jpeg?w=1200',
            'name' => 'Obat Bacterial Spot',
            'shop_id' => 3,
            'description' => 'Obat ini digunakan untuk mengobati penyakit Bacterial Spot pada tanaman.',
            'price' => '50000',
            'type' => 'Bacterial Spot',
        ]);

        Product::create([
            'gambarUrl' => 'https://awsimages.detik.net.id/community/media/visual/2021/10/20/manfaat-jamu-kelor-3_169.jpeg?w=1200',
            'name' => 'Obat Early Blight',
            'shop_id' => 3,
            'description' => 'Obat ini digunakan untuk mengobati penyakit Early Blight pada tanaman.',
            'price' => '45000',
            'type' => 'Early Blight',
        ]);

        Product::create([
            'gambarUrl' => 'https://awsimages.detik.net.id/community/media/visual/2021/10/20/manfaat-jamu-kelor-3_169.jpeg?w=1200',
            'name' => 'Obat Healthy',
            'shop_id' => 3,
            'description' => 'Obat ini untuk menjaga kesehatan tanaman agar tetap sehat.',
            'price' => '55000',
            'type' => 'Healthy',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Obat Bacterial Spot',
            'shop_id' => 3,
            'description' => 'Obat ini digunakan untuk mengobati penyakit Bacterial Spot pada tanaman.',
            'price' => 50000,
            'disease_id' => 1,
        ]);

        Product::create([
            'name' => 'Obat Early Blight',
            'shop_id' => 3,
            'description' => 'Obat ini digunakan untuk mengobati penyakit Early Blight pada tanaman.',
            'price' => 45000,
            'disease_id' => 2,
        ]);

        Product::create([
            'name' => 'Obat Healthy',
            'shop_id' => 3,
            'description' => 'Obat ini untuk menjaga kesehatan tanaman agar tetap sehat.',
            'price' => 55000,
            'disease_id' => 3,
        ]);
    }
}

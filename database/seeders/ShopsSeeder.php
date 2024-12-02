<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shop::create([
            'user_id' => 1,
            'name' => 'Shop Tanaman Sehat',
            'address' => 'Jl. Sehat No. 10, Jakarta',
            'description' => 'Shop yang menyediakan berbagai jenis tanaman sehat dan berkualitas.',
            'operational' => '09:00 - 18:00',
            'noHp' => '081234567890',
        ]);

        Shop::create([
            'user_id' => 2,
            'name' => 'Shop Organik Makmur',
            'address' => 'Jl. Organik No. 5, Bandung',
            'description' => 'Menjual produk-produk organik, termasuk sayuran dan buah-buahan segar.',
            'operational' => '08:00 - 17:00',
            'noHp' => '081234567891',
        ]);

        Shop::create([
            'user_id' => 3,
            'name' => 'Shop Pertanian Sejahtera',
            'address' => 'Jl. Pertanian No. 15, Yogyakarta',
            'description' => 'Shop alat pertanian dan perlengkapan berkebun.',
            'operational' => '07:00 - 16:00',
            'noHp' => '081234567892',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Toko;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Toko::create([
            'user_id' => 1,
            'nama_toko' => 'Toko Tanaman Sehat',
            'alamat' => 'Jl. Sehat No. 10, Jakarta',
            'deskripsi' => 'Toko yang menyediakan berbagai jenis tanaman sehat dan berkualitas.',
            'jam_operasional' => '09:00 - 18:00',
            'gambarUrl' => 'https://warta.luwutimurkab.go.id/wp-content/uploads/2021/07/IMG-20210707-WA0034.jpg',
        ]);

        Toko::create([
            'user_id' => 2,
            'nama_toko' => 'Toko Organik Makmur',
            'alamat' => 'Jl. Organik No. 5, Bandung',
            'deskripsi' => 'Menjual produk-produk organik, termasuk sayuran dan buah-buahan segar.',
            'jam_operasional' => '08:00 - 17:00',
            'gambarUrl' => 'https://warta.luwutimurkab.go.id/wp-content/uploads/2021/07/IMG-20210707-WA0034.jpg',
        ]);

        Toko::create([
            'user_id' => 3,
            'nama_toko' => 'Toko Pertanian Sejahtera',
            'alamat' => 'Jl. Pertanian No. 15, Yogyakarta',
            'deskripsi' => 'Toko alat pertanian dan perlengkapan berkebun.',
            'jam_operasional' => '07:00 - 16:00',
            'gambarUrl' => 'https://warta.luwutimurkab.go.id/wp-content/uploads/2021/07/IMG-20210707-WA0034.jpg',
        ]);
    }
}

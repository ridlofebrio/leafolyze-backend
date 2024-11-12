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
            'gambarUrlObat' => 'https://awsimages.detik.net.id/community/media/visual/2021/10/20/manfaat-jamu-kelor-3_169.jpeg?w=1200',
            'namaObat' => 'Obat Bacterial Spot',
            'user_id' => 3,
            'deskripsi' => 'Obat ini digunakan untuk mengobati penyakit Bacterial Spot pada tanaman.',
            'harga' => '50000',
            'jenis' => 'Bacterial Spot',
        ]);

        Obat::create([
            'gambarUrlObat' => 'https://awsimages.detik.net.id/community/media/visual/2021/10/20/manfaat-jamu-kelor-3_169.jpeg?w=1200',
            'namaObat' => 'Obat Early Blight',
            'user_id' => 3,
            'deskripsi' => 'Obat ini digunakan untuk mengobati penyakit Early Blight pada tanaman.',
            'harga' => '45000',
            'jenis' => 'Early Blight',
        ]);

        Obat::create([
            'gambarUrlObat' => 'https://awsimages.detik.net.id/community/media/visual/2021/10/20/manfaat-jamu-kelor-3_169.jpeg?w=1200',
            'namaObat' => 'Obat Healthy',
            'user_id' => 3,
            'deskripsi' => 'Obat ini untuk menjaga kesehatan tanaman agar tetap sehat.',
            'harga' => '55000',
            'jenis' => 'Healthy',
        ]);
    }
}

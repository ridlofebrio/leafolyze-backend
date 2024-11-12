<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artikel::create([
            'user_id' => 1,
            'judul' => 'Cara Merawat Tanaman',
            'konten' => 'Panduan lengkap untuk merawat tanaman agar tetap sehat dan subur.',
            'gambarUrl' => 'https://images.newscientist.com/wp-content/uploads/2024/09/06132745/iceland-2608985_1920.jpg?crop=3%3A2%2Csmart',
            'durasi_baca' => 5,
        ]);

        Artikel::create([
            'user_id' => 1,
            'judul' => 'Penyakit pada Tanaman dan Cara Mengatasinya',
            'konten' => 'Penjelasan tentang berbagai penyakit tanaman dan langkah-langkah untuk mengatasi.',
            'gambarUrl' => 'https://images.newscientist.com/wp-content/uploads/2024/09/06132745/iceland-2608985_1920.jpg?crop=3%3A2%2Csmart',
            'durasi_baca' => 8,
        ]);

        Artikel::create([
            'user_id' => 1,
            'judul' => 'Tips Bertanam di Musim Hujan',
            'konten' => 'Tips dan trik agar tanaman tetap tumbuh subur di musim hujan.',
            'gambarUrl' => 'https://images.newscientist.com/wp-content/uploads/2024/09/06132745/iceland-2608985_1920.jpg?crop=3%3A2%2Csmart',
            'durasi_baca' => 6,
        ]);
    }
}

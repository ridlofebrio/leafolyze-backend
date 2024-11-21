<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::create([
            'title' => 'Cara Merawat Tanaman',
            'content' => 'Panduan lengkap untuk merawat tanaman agar tetap sehat dan subur.',
            'duration' => 5,
        ]);

        Article::create([
            'title' => 'Penyakit pada Tanaman dan Cara Mengatasinya',
            'content' => 'Penjelasan tentang berbagai penyakit tanaman dan langkah-langkah untuk mengatasi.',
            'duration' => 8,
        ]);

        Article::create([
            'title' => 'Tips Bertanam di Musim Hujan',
            'content' => 'Tips dan trik agar tanaman tetap tumbuh subur di musim hujan.',
            'duration' => 6,
        ]);
    }
}
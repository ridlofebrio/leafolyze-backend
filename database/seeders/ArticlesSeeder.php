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
            'user_id' => 1,
            'title' => 'Cara Merawat Tanaman',
            'content' => 'Panduan lengkap untuk merawat tanaman agar tetap sehat dan subur.',
            'gambarUrl' => 'https://images.newscientist.com/wp-content/uploads/2024/09/06132745/iceland-2608985_1920.jpg?crop=3%3A2%2Csmart',
            'duration' => 5,
        ]);

        Article::create([
            'user_id' => 1,
            'title' => 'Penyakit pada Tanaman dan Cara Mengatasinya',
            'content' => 'Penjelasan tentang berbagai penyakit tanaman dan langkah-langkah untuk mengatasi.',
            'gambarUrl' => 'https://images.newscientist.com/wp-content/uploads/2024/09/06132745/iceland-2608985_1920.jpg?crop=3%3A2%2Csmart',
            'duration' => 8,
        ]);

        Article::create([
            'user_id' => 1,
            'title' => 'Tips Bertanam di Musim Hujan',
            'content' => 'Tips dan trik agar tanaman tetap tumbuh subur di musim hujan.',
            'gambarUrl' => 'https://images.newscientist.com/wp-content/uploads/2024/09/06132745/iceland-2608985_1920.jpg?crop=3%3A2%2Csmart',
            'duration' => 6,
        ]);
    }
}

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
            'content' => 'Merawat tanaman adalah salah satu cara untuk memastikan tanaman tetap sehat dan tumbuh dengan baik. Pertama, perhatikan kebutuhan sinar matahari setiap tanaman, karena beberapa jenis memerlukan sinar matahari penuh, sementara yang lain lebih cocok di tempat teduh. Selanjutnya, pastikan menyiram tanaman secara teratur, tetapi jangan sampai berlebihan karena hal ini dapat menyebabkan akar membusuk. Gunakan pupuk organik secara berkala untuk memastikan tanaman mendapatkan nutrisi yang cukup. Selain itu, penting untuk memangkas bagian tanaman yang sudah mati atau kering untuk mendorong pertumbuhan baru. Jangan lupa untuk memantau hama atau penyakit yang mungkin menyerang tanaman Anda. Dengan perawatan yang tepat, tanaman Anda akan tetap sehat dan subur sepanjang tahun.',
            'duration' => 5,
        ]);

        Article::create([
            'title' => 'Penyakit pada Tanaman dan Cara Mengatasinya',
            'content' => 'Tanaman sering kali menghadapi berbagai penyakit yang dapat menghambat pertumbuhan dan bahkan menyebabkan kematian. Salah satu penyakit yang umum adalah jamur pada daun yang sering disebabkan oleh kelembapan yang berlebihan. Untuk mengatasi hal ini, potong bagian daun yang terinfeksi dan pastikan sirkulasi udara di sekitar tanaman tetap baik. Penyakit lain yang sering terjadi adalah busuk akar akibat penyiraman yang berlebihan. Solusinya adalah mengganti tanah dengan yang baru dan memastikan pot memiliki drainase yang baik. Selain itu, serangan hama seperti kutu daun atau ulat dapat merusak tanaman. Gunakan insektisida alami seperti campuran air dan sabun untuk menghilangkannya. Dengan mengenali gejala penyakit dan mengambil langkah-langkah pencegahan, Anda dapat menjaga tanaman tetap sehat dan produktif.',
            'duration' => 8,
        ]);

        Article::create([
            'title' => 'Tips Bertanam di Musim Hujan',
            'content' => 'Musim hujan adalah waktu yang menantang bagi para pecinta tanaman, tetapi dengan strategi yang tepat, Anda dapat memastikan tanaman tetap tumbuh subur. Pertama, pilih jenis tanaman yang tahan terhadap curah hujan tinggi, seperti tanaman hias berdaun tebal atau sayuran seperti kangkung dan bayam. Gunakan media tanam dengan drainase yang baik untuk mencegah genangan air di pot. Selain itu, hindari penyiraman tambahan selama musim hujan kecuali jika benar-benar diperlukan. Jika tanaman Anda berada di luar ruangan, pertimbangkan untuk menggunakan penutup plastik untuk melindunginya dari hujan deras. Bersihkan gulma secara rutin karena gulma cenderung tumbuh lebih cepat di musim hujan dan dapat menghambat pertumbuhan tanaman Anda. Dengan menerapkan tips ini, tanaman Anda akan tetap sehat meskipun cuaca sedang tidak bersahabat.',
            'duration' => 6,
        ]);
    }
}

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
            'name' => 'Obat Bacterial Spot - Varian 1',
            'shop_id' => 3,
            'description' => 'Obat ini efektif melawan infeksi Bacterial Spot, membantu daun tetap hijau dan sehat.',
            'price' => 45000,
            'disease_id' => 1,
        ]);

        Product::create([
            'name' => 'Obat Bacterial Spot - Varian 2',
            'shop_id' => 3,
            'description' => 'Dirancang untuk memulihkan tanaman yang terinfeksi Bacterial Spot dengan cepat.',
            'price' => 50000,
            'disease_id' => 1,
        ]);

        Product::create([
            'name' => 'Obat Bacterial Spot - Varian 3',
            'shop_id' => 3,
            'description' => 'Solusi ampuh untuk mencegah penyebaran Bacterial Spot di tanaman.',
            'price' => 55000,
            'disease_id' => 1,
        ]);

        Product::create([
            'name' => 'Obat Early Blight - Varian 1',
            'shop_id' => 3,
            'description' => 'Obat ini membantu mengatasi gejala awal penyakit Early Blight pada daun.',
            'price' => 48000,
            'disease_id' => 2,
        ]);

        Product::create([
            'name' => 'Obat Early Blight - Varian 2',
            'shop_id' => 3,
            'description' => 'Mengurangi dampak Early Blight pada tanaman dengan perlindungan optimal.',
            'price' => 52000,
            'disease_id' => 2,
        ]);

        Product::create([
            'name' => 'Obat Early Blight - Varian 3',
            'shop_id' => 3,
            'description' => 'Formulasi khusus untuk melawan jamur penyebab Early Blight secara efektif.',
            'price' => 55000,
            'disease_id' => 2,
        ]);

        Product::create([
            'name' => 'Obat Healthy - Varian 1',
            'shop_id' => 3,
            'description' => 'Nutrisi tambahan untuk menjaga tanaman tetap sehat dan kuat.',
            'price' => 47000,
            'disease_id' => 3,
        ]);

        Product::create([
            'name' => 'Obat Healthy - Varian 2',
            'shop_id' => 3,
            'description' => 'Meningkatkan ketahanan tanaman terhadap stres lingkungan.',
            'price' => 51000,
            'disease_id' => 3,
        ]);

        Product::create([
            'name' => 'Obat Healthy - Varian 3',
            'shop_id' => 3,
            'description' => 'Mendukung pertumbuhan tanaman yang sehat tanpa penyakit.',
            'price' => 56000,
            'disease_id' => 3,
        ]);

        Product::create([
            'name' => 'Obat Late Blight - Varian 1',
            'shop_id' => 3,
            'description' => 'Obat ampuh untuk melawan penyakit Late Blight pada tanaman.',
            'price' => 48000,
            'disease_id' => 4,
        ]);

        Product::create([
            'name' => 'Obat Late Blight - Varian 2',
            'shop_id' => 3,
            'description' => 'Dirancang untuk mencegah penyebaran penyakit Late Blight di lingkungan basah.',
            'price' => 52000,
            'disease_id' => 4,
        ]);

        Product::create([
            'name' => 'Obat Late Blight - Varian 3',
            'shop_id' => 3,
            'description' => 'Solusi terbaik untuk mengatasi Late Blight secara cepat.',
            'price' => 56000,
            'disease_id' => 4,
        ]);

        Product::create([
            'name' => 'Obat Leaf Mold - Varian 1',
            'shop_id' => 3,
            'description' => 'Obat ini mengatasi bercak kuning pada daun akibat penyakit Leaf Mold.',
            'price' => 47000,
            'disease_id' => 5,
        ]);

        Product::create([
            'name' => 'Obat Leaf Mold - Varian 2',
            'shop_id' => 3,
            'description' => 'Melindungi tanaman dari infeksi jamur Leaf Mold secara efektif.',
            'price' => 51000,
            'disease_id' => 5,
        ]);

        Product::create([
            'name' => 'Obat Leaf Mold - Varian 3',
            'shop_id' => 3,
            'description' => 'Pencegahan terbaik untuk mengatasi Leaf Mold pada tanaman.',
            'price' => 56000,
            'disease_id' => 5,
        ]);

        Product::create([
            'name' => 'Obat Target Spot - Varian 1',
            'shop_id' => 3,
            'description' => 'Efektif untuk mengatasi bercak coklat kecil akibat Target Spot.',
            'price' => 47000,
            'disease_id' => 6,
        ]);

        Product::create([
            'name' => 'Obat Target Spot - Varian 2',
            'shop_id' => 3,
            'description' => 'Melindungi tanaman dari penyakit Target Spot dengan perlindungan optimal.',
            'price' => 51000,
            'disease_id' => 6,
        ]);

        Product::create([
            'name' => 'Obat Target Spot - Varian 3',
            'shop_id' => 3,
            'description' => 'Obat ini dirancang untuk mencegah infeksi Target Spot secara menyeluruh.',
            'price' => 56000,
            'disease_id' => 6,
        ]);

        Product::create([
            'name' => 'Obat Black Spot - Varian 1',
            'shop_id' => 3,
            'description' => 'Solusi cepat untuk menangani bercak hitam pada daun akibat Black Spot.',
            'price' => 47000,
            'disease_id' => 7,
        ]);

        Product::create([
            'name' => 'Obat Black Spot - Varian 2',
            'shop_id' => 3,
            'description' => 'Obat ini efektif mencegah penyebaran Black Spot di tanaman.',
            'price' => 51000,
            'disease_id' => 7,
        ]);

        Product::create([
            'name' => 'Obat Black Spot - Varian 3',
            'shop_id' => 3,
            'description' => 'Formulasi khusus untuk menghilangkan bercak hitam secara tuntas.',
            'price' => 56000,
            'disease_id' => 7,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GambarSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gambar')->insert([
            [
                'gambarUrl' => 'https://www.biofarma.co.id/media/image/originals/post/2024/09/20/daun-sirih-beautiful-green-leaf-texture-piper-betle-leaf-daun-sirih-medicinal-purposes.jpg',
                'user_id' => 1,  // Assuming this user exists, or you can set this to null
                'description' => 'This is the first sample image.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gambarUrl' => 'https://www.biofarma.co.id/media/image/originals/post/2024/09/20/daun-sirih-beautiful-green-leaf-texture-piper-betle-leaf-daun-sirih-medicinal-purposes.jpg',
                'user_id' => 2,  // Assuming this user exists, or set to null if no users exist yet
                'description' => 'This is the second sample image.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gambarUrl' => 'https://www.biofarma.co.id/media/image/originals/post/2024/09/20/daun-sirih-beautiful-green-leaf-texture-piper-betle-leaf-daun-sirih-medicinal-purposes.jpg',
                'user_id' => 1,  // Nullable foreign key
                'description' => 'This image was uploaded by a guest.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
 }



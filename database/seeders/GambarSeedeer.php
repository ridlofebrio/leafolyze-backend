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
                'gambarUrl' => 'https://example.com/image1.jpg',
                'user_id' => 1,  // Assuming this user exists, or you can set this to null
                'deskripsi' => 'This is the first sample image.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gambarUrl' => 'https://example.com/image2.jpg',
                'user_id' => 2,  // Assuming this user exists, or set to null if no users exist yet
                'deskripsi' => 'This is the second sample image.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gambarUrl' => 'https://example.com/image3.jpg',
                'user_id' => 1,  // Nullable foreign key
                'deskripsi' => 'This image was uploaded by a guest.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
 }



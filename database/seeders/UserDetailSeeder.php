<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserDetail;
use App\Models\User;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        UserDetail::create([
            'user_id' => 1,
            'name' => 'Admin User',
            'birth' => '1980-01-01',
            'gender' => 'Laki-laki',
            'address' => 'Jalan Admin 1',
            'gambarUrl' => 'https://awsimages.detik.net.id/community/media/visual/2018/03/03/39f24229-6f26-4a17-aa92-44c3bd3dae9e_43.jpeg?w=600&q=90',
        ]);

        UserDetail::create([
            'user_id' => 2,
            'name' => 'Petani User',
            'birth' => '1990-05-15',
            'gender' => 'Perempuan',
            'address' => 'Jalan Petani 5',
            'gambarUrl' => 'https://awsimages.detik.net.id/community/media/visual/2018/03/03/39f24229-6f26-4a17-aa92-44c3bd3dae9e_43.jpeg?w=600&q=90',
        ]);

        UserDetail::create([
            'user_id' => 3,
            'name' => 'Penjual User',
            'birth' => '1995-08-20',
            'gender' => 'Laki-laki',
            'address' => 'Jalan Penjual 3',
            'gambarUrl' => 'https://awsimages.detik.net.id/community/media/visual/2018/03/03/39f24229-6f26-4a17-aa92-44c3bd3dae9e_43.jpeg?w=600&q=90',
        ]);
    }
}

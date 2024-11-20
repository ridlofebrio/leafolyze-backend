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
        ]);

        UserDetail::create([
            'user_id' => 2,
            'name' => 'Petani User',
            'birth' => '1990-05-15',
            'gender' => 'Perempuan',
            'address' => 'Jalan Petani 5',
        ]);

        UserDetail::create([
            'user_id' => 3,
            'name' => 'Penjual User',
            'birth' => '1995-08-20',
            'gender' => 'Laki-laki',
            'address' => 'Jalan Penjual 3',
        ]);
    }
}

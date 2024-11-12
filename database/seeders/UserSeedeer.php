<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'Acces' => 'admin',
        ]);

        User::create([
            'email' => 'petani@example.com',
            'password' => Hash::make('password123'),
            'Acces' => 'petani',
        ]);

        User::create([
            'email' => 'penjual@example.com',
            'password' => Hash::make('password123'),
            'Acces' => 'penjual',
        ]);
    }
}

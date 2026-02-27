<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Petugas',
            'email' => 'petugas@example.com',
            'password' => 'password',
            'role' => 'petugas'
        ]);

        User::create([
            'name' => 'Peminjam',
            'email' => 'peminjam@example.com',
            'password' => 'password',
            'role' => 'peminjam'
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus user lama jika ada (opsional, bagus untuk testing)
        // User::truncate();

        // Buat user admin
        User::create([
            'username' => 'admin',
            'email' => 'admin@jwrcomp.com',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
            'role' => 'admin',
        ]);

        // Buat user biasa untuk testing (opsional)
        User::create([
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}   
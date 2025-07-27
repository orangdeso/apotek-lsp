<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@apotek.com',
            'password' => Hash::make('admin123'),
            'alamat' => 'Jl. Admin No. 1',
            'kota' => 'Jakarta',
            'telpon' => '081234567890',
            'role' => 'admin'
        ]);

        // Create Apoteker User
        User::create([
            'name' => 'Apoteker User',
            'email' => 'apoteker@apotek.com',
            'password' => Hash::make('apoteker123'),
            'alamat' => 'Jl. Apoteker No. 2',
            'kota' => 'Jakarta',
            'telpon' => '081234567891',
            'role' => 'apoteker'
        ]);

        // Create Pelanggan User
        User::create([
            'name' => 'Pelanggan User',
            'email' => 'pelanggan@apotek.com',
            'password' => Hash::make('pelanggan123'),
            'alamat' => 'Jl. Pelanggan No. 3',
            'kota' => 'Jakarta',
            'telpon' => '081234567892',
            'role' => 'pelanggan'
        ]);
    }
}

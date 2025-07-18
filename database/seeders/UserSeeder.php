<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Admin user
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Kasir user
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@toko.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);
    }
}

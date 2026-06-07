<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password'), 'password_plain' => 'password', 'role' => 'admin']
        );

        // Siswa 1
        User::updateOrCreate(
            ['email' => 'siswa1@siswa.com'],
            ['name' => 'Siswa 1', 'password' => Hash::make('password'), 'password_plain' => 'password', 'role' => 'siswa']
        );

        // Siswa 2
        User::updateOrCreate(
            ['email' => 'siswa2@siswa.com'],
            ['name' => 'Siswa 2', 'password' => Hash::make('password'), 'password_plain' => 'password', 'role' => 'siswa']
        );

        // Siswa 3
        User::updateOrCreate(
            ['email' => 'siswa3@siswa.com'],
            ['name' => 'Siswa 3', 'password' => Hash::make('password'), 'password_plain' => 'password', 'role' => 'siswa']
        );
        
        // Siswa 4 (untuk mengetes limit)
        User::updateOrCreate(
            ['email' => 'siswa4@siswa.com'],
            ['name' => 'Siswa 4', 'password' => Hash::make('password'), 'password_plain' => 'password', 'role' => 'siswa']
        );
    }
}

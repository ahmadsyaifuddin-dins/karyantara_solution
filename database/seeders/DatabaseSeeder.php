<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun admin tunggal
        User::factory()->create([
            'name' => 'Admin Karyantara',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Ganti dengan password yang lebih aman nanti
        ]);
    }
}

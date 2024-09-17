<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@laravel.com',
            'role_id' => 'ADM001',
            'password' => Hash::make('laravel_admin123'),
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@laravel.com',
            'role_id' => 'USR001',
            'password' => Hash::make('laravel_user123'),
        ]);
    }
}

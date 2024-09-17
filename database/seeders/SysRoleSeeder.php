<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SysRole;

class SysRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SysRole::create([
            'role_id' => 'ADM001',
            'role_name' => 'Administrator',
            'created_at' => now()
        ]);

        SysRole::create([
            'role_id' => 'USR001',
            'role_name' => 'User',
            'created_at' => now()
        ]);
    }
}

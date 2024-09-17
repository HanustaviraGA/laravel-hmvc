<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SysRoleMenu;

class SysRoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        SysRoleMenu::create([
            'role_menu_id' => md5(rand(0, 100).date('Y-m-d H:i:s').uniqid()),
            'role_menu_menu_id' => 'A001',
            'role_menu_role_id' => 'ADM001',
            'created_at' => now()
        ]);

        SysRoleMenu::create([
            'role_menu_id' => md5(rand(0, 100).date('Y-m-d H:i:s').uniqid()),
            'role_menu_menu_id' => 'A0011',
            'role_menu_role_id' => 'ADM001',
            'created_at' => now()
        ]);

        SysRoleMenu::create([
            'role_menu_id' => md5(rand(0, 100).date('Y-m-d H:i:s').uniqid()),
            'role_menu_menu_id' => 'A002',
            'role_menu_role_id' => 'ADM001',
            'created_at' => now()
        ]);

        SysRoleMenu::create([
            'role_menu_id' => md5(rand(0, 100).date('Y-m-d H:i:s').uniqid()),
            'role_menu_menu_id' => 'A0021',
            'role_menu_role_id' => 'ADM001',
            'created_at' => now()
        ]);

        SysRoleMenu::create([
            'role_menu_id' => md5(rand(0, 100).date('Y-m-d H:i:s').uniqid()),
            'role_menu_menu_id' => 'A0022',
            'role_menu_role_id' => 'ADM001',
            'created_at' => now()
        ]);
    }
}

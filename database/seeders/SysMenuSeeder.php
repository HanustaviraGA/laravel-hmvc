<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SysMenu;

class SysMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dashboard
        SysMenu::create([
            'menu_id' => 'A001',
            'menu_kode' => 'home',
            'menu_judul' => 'Home',
            'menu_order' => '00',
            'menu_parent' => '#',
            'menu_aktif' => 1,
            'menu_icon' => 'las la-user fs-2x',
            'menu_level' => '1',
            'menu_sub' => 1,
            'created_at' => now()
        ]);

        SysMenu::create([
            'menu_id' => 'A0011',
            'menu_kode' => 'dashboard',
            'menu_judul' => 'Dashboard',
            'menu_order' => '00.01',
            'menu_parent' => 'A001',
            'menu_aktif' => 1,
            'menu_icon' => 'las la-user fs-2x',
            'menu_level' => '2',
            'menu_sub' => 0,
            'created_at' => now()
        ]);

        // Pengaturan
        SysMenu::create([
            'menu_id' => 'A002',
            'menu_kode' => 'pengaturan',
            'menu_judul' => 'Pengaturan',
            'menu_order' => '01',
            'menu_parent' => '#',
            'menu_aktif' => 1,
            'menu_icon' => 'las la-user fs-2x',
            'menu_level' => '1',
            'menu_sub' => 1,
            'created_at' => now()
        ]);

        SysMenu::create([
            'menu_id' => 'A0021',
            'menu_kode' => 'hakakses',
            'menu_judul' => 'Hak Akses',
            'menu_order' => '01.01',
            'menu_parent' => 'A002',
            'menu_aktif' => 1,
            'menu_icon' => 'las la-user fs-2x',
            'menu_level' => '2',
            'menu_sub' => 0,
            'created_at' => now()
        ]);

        SysMenu::create([
            'menu_id' => 'A0022',
            'menu_kode' => 'user',
            'menu_judul' => 'Master User',
            'menu_order' => '01.02',
            'menu_parent' => 'A002',
            'menu_aktif' => 1,
            'menu_icon' => 'las la-user fs-2x',
            'menu_level' => '2',
            'menu_sub' => 0,
            'created_at' => now()
        ]);
    }
}

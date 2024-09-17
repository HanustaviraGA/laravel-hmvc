<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE
            VIEW `view_sys_role_menu` AS
            SELECT
                `crm`.`role_menu_id` AS `role_menu_id`,
                `crm`.`role_menu_menu_id` AS `role_menu_menu_id`,
                `crm`.`role_menu_role_id` AS `role_menu_role_id`,
                `cm`.`menu_id` AS `menu_id`,
                `cm`.`menu_kode` AS `menu_kode`,
                `cm`.`menu_judul` AS `menu_judul`,
                `cm`.`menu_order` AS `menu_order`,
                `cm`.`menu_parent` AS `menu_parent`,
                `cm`.`menu_aktif` AS `menu_aktif`,
                `cm`.`menu_icon` AS `menu_icon`,
                `cm`.`menu_level` AS `menu_level`,
                `cm`.`menu_sub` AS `menu_sub`,
                `cm`.`created_at` AS `created_at`,
                `cm`.`updated_at` AS `updated_at`,
                `cr`.`role_id` AS `role_id`,
                `cr`.`role_name` AS `role_name`
            FROM
                `sys_role_menu` `crm`
            LEFT JOIN `sys_menu` `cm` ON
                `crm`.`role_menu_menu_id` = `cm`.`menu_id`
            LEFT JOIN `sys_role` `cr` ON
                `crm`.`role_menu_role_id` = `cr`.`role_id`;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS view_sys_role_menu');
    }
};

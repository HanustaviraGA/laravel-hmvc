<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sys_menu', function (Blueprint $table) {
            $table->string('menu_id')->primary();
            $table->string('menu_kode')->unique();
            $table->string('menu_judul')->nullable();
            $table->string('menu_order')->nullable();
            $table->string('menu_parent')->nullable();
            $table->integer('menu_aktif')->nullable();
            $table->string('menu_icon')->nullable();
            $table->string('menu_level')->nullable();
            $table->integer('menu_sub')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_menu');
    }
};

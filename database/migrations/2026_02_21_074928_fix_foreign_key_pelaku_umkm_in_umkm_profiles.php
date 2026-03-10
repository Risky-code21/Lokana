<?php
// database/migrations/2026_02_21_xxxxxx_fix_foreign_key_pelaku_umkm_in_umkm_profiles.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus foreign key lama yang mengarah ke users
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->dropForeign(['pelaku_umkm']);
        });

        // Buat foreign key baru yang mengarah ke pelaku_umkms
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->foreign('pelaku_umkm')
                  ->references('id')
                  ->on('pelaku_umkms')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Kembalikan ke foreign key ke users
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->dropForeign(['pelaku_umkm']);
        });

        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->foreign('pelaku_umkm')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
};
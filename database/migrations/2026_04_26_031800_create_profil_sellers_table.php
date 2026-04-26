<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seller', function (Blueprint $table) {
            if (!Schema::hasColumn('seller', 'nama_toko')) {
                $table->string('nama_toko')->nullable();
            }
            if (!Schema::hasColumn('seller', 'nomor_hp')) {
                $table->string('nomor_hp')->nullable();
            }
            if (!Schema::hasColumn('seller', 'deskripsi_toko')) {
                $table->text('deskripsi_toko')->nullable();
            }
            if (!Schema::hasColumn('seller', 'foto_profil')) {
                $table->string('foto_profil')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('seller', function (Blueprint $table) {
            $table->dropColumn(['nama_toko', 'nomor_hp', 'deskripsi_toko', 'foto_profil']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom nomor handphone jika belum ada 
            if (!Schema::hasColumn('users', 'nomor_handphone')) {
                $table->string('nomor_handphone')->nullable()->after('email');
            }
            
            // Menambahkan kolom foto jika belum ada
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('nomor_handphone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nomor_handphone', 'foto']);
        });
    }
};
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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('id_profil_customer')->nullable();
            $table->string('kode_pesanan')->unique()->nullable();
            $table->string('metode_bayar')->default('online')->after('kode_pesanan');
            $table->string('status_midtrans')->nullable()->after('metode_bayar');
            $table->text('snap_token')->nullable()->after('status_midtrans');
            $table->string('kode_unik', 6)->nullable()->after('snap_token');
            $table->text('catatan')->nullable()->after('kode_unik');
            $table->timestamp('waktu_pengambilan')->nullable()->after('catatan');

            $table->foreign('id_profil_customer')
                ->references('id')->on('profil_customers')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};

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
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_produk')->constrained('produks', 'id')->cascadeOnDelete();
            $table->foreignId('id_seller')->constrained('seller', 'id')->cascadeOnDelete();
            $table->foreignId('id_profil_customer')->constrained('profil_customers', 'id')->cascadeOnDelete();
            $table->integer('jumlah')->default(1);
            $table->text('catatan')->nullable(); // Untuk request khusus dari pembeli, misal: sambalnya dipisah ya
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};

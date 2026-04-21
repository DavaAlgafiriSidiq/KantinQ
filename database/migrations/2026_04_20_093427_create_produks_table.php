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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_seller')->constrained('seller', 'id')->cascadeOnDelete();
            $table->foreignId('id_kategori')->constrained('kategoris', 'id')->cascadeOnDelete();
            $table->string('nama_produk', 100);
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2);
            $table->integer('stok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};

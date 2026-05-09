<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('favorites', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_produk')->constrained('produks')->onDelete('cascade');
        $table->foreignId('id_order')->constrained('orders')->onDelete('cascade'); 
        $table->timestamps();
    });
}
};

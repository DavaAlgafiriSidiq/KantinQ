<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_customers', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); 
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_customers');
    }
};
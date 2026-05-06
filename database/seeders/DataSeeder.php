<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AkunSellerModel as Seller;
use App\Models\produk;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Membuat 5 seller, dan untuk setiap seller buat 3 produk
    Seller::factory()->count(5)->has(
    Produk::factory()->count(3)
    )->create();
}
}

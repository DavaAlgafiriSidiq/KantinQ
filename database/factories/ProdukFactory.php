<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\AkunSellerModel as Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_seller' => Seller::factory(), // Membuat seller otomatis
            'id_kategori' => 1, // Sesuaikan dengan ID kategori yang ada
            'nama_produk' => $this->faker->word,
            'deskripsi' => $this->faker->paragraph,
            'harga' => $this->faker->numberBetween(10000, 100000),
            'stok' => $this->faker->numberBetween(1, 50),
            'status' => 'tersedia',
            'foto_produk' => 'produk.jpg',
        ];
    }
}

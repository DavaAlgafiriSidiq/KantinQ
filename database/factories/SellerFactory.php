<?php

namespace Database\Factories;

use App\Models\AkunSellerModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AkunSellerModel>
 */
class SellerFactory extends Factory
{
    // Tambahkan baris ini agar Laravel tahu modelnya adalah AkunSellerModel
    protected $model = AkunSellerModel::class;

    public function definition()
    {
        return [
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password123'),
            'nama_toko' => $this->faker->company,
            'nomor_hp' => $this->faker->phoneNumber,
            'deskripsi_toko' => $this->faker->sentence,
            'foto_profil' => 'default.jpg',
        ];
    }
}
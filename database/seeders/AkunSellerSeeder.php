<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AkunSellerModel;

class AkunSellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            [
                'username' => 'seller1',
                'email' => 'seller1@email.com',
                'password' => Hash::make('seller123'),
            ],
        ];

        AkunSellerModel::insert($data);
    }
}

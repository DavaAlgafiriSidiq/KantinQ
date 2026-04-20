<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Makanan Berat'],
            ['nama_kategori' => 'Camilan'],
            ['nama_kategori' => 'Minuman'],
            ['nama_kategori' => 'Lainnya'], //untuk kategori lain-lain, misalnya alat tulis, pakaian, dll
        ];

        foreach ($kategori as $k) {
            Kategori::create($k);
        }
    }
}
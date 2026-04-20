<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        //untuk mempermudah, kategori makanan kita definisikan disini, jadi kita tidak perlu repot-repot mencari id kategori
        $makananId = Kategori::where('nama_kategori', 'Makanan Berat')->first()->id ?? 1;
        $minumanId = Kategori::where('nama_kategori', 'Minuman')->first()->id ?? 2;
        $camilanId = Kategori::where('nama_kategori', 'Camilan')->first()->id ?? 3;
        $lainnyaId = Kategori::where('nama_kategori', 'Lainnya')->first()->id ?? 4;

        Produk::create([
            'id_seller' => '1',
            'id_kategori' => $makananId,
            'nama_produk' => 'Ayam Geprek',
            'deskripsi' => 'Ayam goreng yang digeprek dengan sambal pedas',
            'harga' => 15000,
            'stok' => 20,
        ]);

        Produk::create([
            'id_seller' => '1',
            'id_kategori' => $minumanId,
            'nama_produk' => 'Es Teh Manis',
            'deskripsi' => 'Teh segar dengan gula asli',
            'harga' => 5000,
            'stok' => 50,
        ]);

        Produk::create([
            'id_seller' => '1',
            'id_kategori' => $camilanId,
            'nama_produk' => 'Basmut',
            'deskripsi' => 'Basmut adalah singkatan dari baso tahu, yaitu camilan yang terbuat dari campuran daging dan tahu yang dibentuk bulat dan digoreng hingga renyah',
            'harga' => 5000,
            'stok' => 30,
        ]);

        produk::create([
            'id_seller' => '1',
            'id_kategori' => $lainnyaId,
            'nama_produk' => 'Pulpen Sarasa',
            'deskripsi' => 'Pulpen gel dengan tinta yang halus dan cepat kering, cocok untuk menulis di berbagai jenis kertas',
            'harga' => 25000,
            'stok' => 100,
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyOrderSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Target akun kamu
        $sellerId = 14; 

        // 1. Pastikan Produk Tersedia
        $produkId = DB::table('produks')->where('id_seller', $sellerId)->value('id');
        if (!$produkId) {
            $produkId = DB::table('produks')->insertGetId([
                'id_seller' => $sellerId,
                'id_kategori' => 1,
                'nama_produk' => 'Ayam Geprek Spesial',
                'deskripsi' => 'Pedas nikmat',
                'harga' => 15000,
                'stok' => 50,
                'created_at' => $now
            ]);
        }

        // 2. Daftar Status yang Ingin Kita Masukkan (Biar Semua Box Terisi)
        
    
        $daftarPesanan = [
            ['status' => 'baru', 'jumlah' => 3],
            ['status' => 'diproses', 'jumlah' => 2],
            ['status' => 'siap_diambil', 'jumlah' => 2],
            ['status' => 'selesai', 'jumlah' => 5], // Selesai biar Pendapatan Hari Ini naik
        ];

        foreach ($daftarPesanan as $item) {
            for ($i = 0; $i < $item['jumlah']; $i++) {
                // Buat Pesanan Utama
                $orderId = DB::table('orders')->insertGetId([
                    'id_seller' => $sellerId,
                    'total_amount' => 15000,
                    'status' => $item['status'],
                    'created_at' => $now->copy()->subMinutes(rand(1, 60)), // Waktu acak dalam 1 jam terakhir
                    'updated_at' => $now
                ]);

                // Buat Detail Itemnya
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'id_produk' => $produkId,
                    'id_profil_customer' => 999,
                    'quantity' => 1,
                    'price' => 15000,
                    'created_at' => $now
                ]);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->command->info('Berhasil! 12 Pesanan baru telah disuntikkan ke ID 14.');
    }
}
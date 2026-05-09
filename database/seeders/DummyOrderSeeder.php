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

        // Ambil ID Seller yang paling baru kamu buat (biar muncul di dashboardmu)
        $sellerId = DB::table('seller')->max('id');

        if (!$sellerId) {
            $this->command->error('Belum ada akun seller! Daftar dulu ya.');
            return;
        }

        // 1. Pastikan ada Kategori
        $kategoriId = DB::table('kategoris')->insertGetId([
            'nama_kategori' => 'Makanan Dummy',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // 2. Pastikan ada Customer (ID: 999)
        DB::table('profil_customers')->updateOrInsert(
            ['id' => 999],
            [
                'user_id' => 1, // Sesuaikan dengan ID user yang ada
                'name' => 'Nadin Tester',
                'phone' => '08123456789',
                'created_at' => $now,
                'updated_at' => $now
            ]
        );

        // 3. Buat Produk Dummy
        $produkId = DB::table('produks')->insertGetId([
            'id_seller' => $sellerId,
            'id_kategori' => $kategoriId,
            'nama_produk' => 'Ayam Penyet Mantap',
            'deskripsi' => 'Pedesnya nampol beneran',
            'harga' => 15000.00,
            'stok' => 10,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // 4. Buat Daftar Pesanan (Baru, Diproses, Siap Diambil, Selesai)
        $statuses = ['baru', 'diproses', 'siap_diambil', 'selesai'];
        
        foreach ($statuses as $status) {
            $orderId = DB::table('orders')->insertGetId([
                'id_seller' => $sellerId,
                'total_amount' => 15000,
                'status' => $status,
                'created_at' => $now,
                'updated_at' => $now
            ]);

            // Isi Detail Pesanan
            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'id_produk' => $produkId,
                'id_profil_customer' => 999,
                'quantity' => 1,
                'price' => 15000,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        $this->command->info('Data Dummy KantinQ berhasil disuntikkan ke Seller ID: ' . $sellerId);
    }
}
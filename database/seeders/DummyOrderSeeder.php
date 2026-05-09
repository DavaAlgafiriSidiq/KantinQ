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

        // Matikan sementara sistem proteksi relasi MySQL agar injeksi data berjalan mulus
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        //  Ambil ID Seller milikmu 
        $sellerId = DB::table('seller')->min('id');
        if (!$sellerId) {
            $this->command->error('Belum ada akun seller! Register dulu 1 akun seller di web ya.');
            return;
        }

        // Buat Kategori Dummy
        DB::table('kategoris')->insertOrIgnore([
            ['id' => 1, 'nama_kategori' => 'Makanan Utama', 'created_at' => $now],
            ['id' => 2, 'nama_kategori' => 'Minuman Segar', 'created_at' => $now],
        ]);

        //  Buat Customer Dummy (ID: 999)
        DB::table('profil_customers')->insertOrIgnore([
            'id' => 999,
            'user_id' => 999,
            'name' => 'Nadin Customer Dummy',
            'phone' => '08123456789',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        //  Buat 3 Menu Produk Dummy KantinQ
        $produk1 = DB::table('produks')->insertGetId(['id_seller' => $sellerId, 'id_kategori' => 1, 'nama_produk' => 'Nasi Goreng Spesial', 'deskripsi' => 'Pedes manis mantap', 'harga' => 20000, 'stok' => 50, 'created_at' => $now]);
        $produk2 = DB::table('produks')->insertGetId(['id_seller' => $sellerId, 'id_kategori' => 2, 'nama_produk' => 'Es Teh Kampul', 'deskripsi' => 'Seger banget buat siang hari', 'harga' => 5000, 'stok' => 100, 'created_at' => $now]);
        $produk3 = DB::table('produks')->insertGetId(['id_seller' => $sellerId, 'id_kategori' => 1, 'nama_produk' => 'Ayam Geprek Mahasiswa', 'deskripsi' => 'Pedas nampol', 'harga' => 15000, 'stok' => 30, 'created_at' => $now]);

        // Buat 4 Pesanan dengan status yang berbeda-beda
        $orders = [
            ['status' => 'baru',         'total' => 25000, 'waktu' => $now->copy()->subMinutes(2)],  // Baru masuk 2 menit lalu
            ['status' => 'diproses',     'total' => 45000, 'waktu' => $now->copy()->subMinutes(15)], // Dimasak 15 menit lalu
            ['status' => 'siap_diambil', 'total' => 15000, 'waktu' => $now->copy()->subMinutes(30)], // Sudah matang
            ['status' => 'selesai',      'total' => 25000, 'waktu' => $now->copy()->subMinutes(60)], // Selesai 
        ];

        foreach ($orders as $index => $o) {
            $orderId = DB::table('orders')->insertGetId([
                'id_seller' => $sellerId,
                'total_amount' => $o['total'],
                'status' => $o['status'],
                'created_at' => $o['waktu'],
                'updated_at' => $o['waktu'],
            ]);

           
            DB::table('order_items')->insert([
                [
                    'order_id' => $orderId,
                    'id_produk' => $produk1,
                    'id_profil_customer' => 999,
                    'quantity' => 1,
                    'price' => 20000,
                    'created_at' => $o['waktu'],
                ],
                [
                    'order_id' => $orderId,
                    'id_produk' => $produk2,
                    'id_profil_customer' => 999,
                    'quantity' => ($index + 1), 
                    'price' => 5000,
                    'created_at' => $o['waktu'],
                ]
            ]);
        }

        // Nyalakan kembali sistem proteksi database
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Yey! Data Dummy KantinQ berhasil disuntikkan!');
    }
}
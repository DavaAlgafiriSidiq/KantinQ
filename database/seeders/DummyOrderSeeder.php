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

        // JURUS AMPUH: Matikan pengecekan Foreign Key (Kunci Tamu)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Ambil ID Seller paling baru (id kamu yang sedang login)
        $sellerId = 14;

        if (!$sellerId) {
            $this->command->error('Belum ada akun seller! Daftar dulu ya.');
            return;
        }

        // 1. Masukkan Kategori Dummy
        DB::table('kategoris')->updateOrInsert(
            ['id' => 1],
            ['nama_kategori' => 'Makanan Berat', 'created_at' => $now]
        );

        // 2. Masukkan Customer Dummy (Tanpa perlu ada di tabel users)
        DB::table('profil_customers')->updateOrInsert(
            ['id' => 999],
            [
                'user_id' => 1, // Diabaikan karena foreign key dimatikan
                'name' => 'Nadin Tester Dummy',
                'phone' => '08123456789',
                'created_at' => $now,
                'updated_at' => $now
            ]
        );

        // 3. Buat Produk Dummy (Ayam Penyet)
        $produkId = DB::table('produks')->insertGetId([
            'id_seller' => $sellerId,
            'id_kategori' => 1,
            'nama_produk' => 'Ayam Penyet Mantap',
            'deskripsi' => 'Pedesnya nampol beneran',
            'harga' => 15000,
            'stok' => 10,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // 4. Masukkan Pesanan dengan status BARU
        $orderId = DB::table('orders')->insertGetId([
            'id_seller' => $sellerId,
            'total_amount' => 15000,
            'status' => 'baru',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // 5. Masukkan Detail Item Pesanan (AC 7)
        DB::table('order_items')->insert([
            'order_id' => $orderId,
            'id_produk' => $produkId,
            'id_profil_customer' => 999,
            'quantity' => 1,
            'price' => 15000,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // NYALAKAN LAGI sistem keamanan databasenya
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Yey! Data Dummy berhasil masuk ke Seller ID: ' . $sellerId);
    }
}
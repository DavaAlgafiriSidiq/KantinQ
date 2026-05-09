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
        // Matikan proteksi database agar penyuntikan lancar
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // TARGET KHUSUS: Akun KantinQ (ID 14)
        $sellerId = 14; 

        // 1. SIAPKAN KATEGORI
        // Mengikuti daftar kategori yang ada di model produkmu
        DB::table('kategoris')->updateOrInsert(['id' => 1], ['nama_kategori' => 'Makanan Berat', 'created_at' => $now]);
        DB::table('kategoris')->updateOrInsert(['id' => 2], ['nama_kategori' => 'Camilan', 'created_at' => $now]);
        DB::table('kategoris')->updateOrInsert(['id' => 3], ['nama_kategori' => 'Minuman', 'created_at' => $now]);

        // 2. MENU YANG SUPER BERVARIASI
        $menuData = [
            ['kategori' => 1, 'nama' => 'Ayam Geprek Mahasiswa', 'harga' => 15000],
            ['kategori' => 1, 'nama' => 'Nasi Padang Rendang', 'harga' => 22000],
            ['kategori' => 1, 'nama' => 'Indomie Goreng Telur', 'harga' => 10000],
            ['kategori' => 2, 'nama' => 'Seblak Kuah Pedas', 'harga' => 12000],
            ['kategori' => 2, 'nama' => 'Pisang Coklat Lumer', 'harga' => 8000],
            ['kategori' => 2, 'nama' => 'Tempe Mendoan (Isi 3)', 'harga' => 5000],
            ['kategori' => 3, 'nama' => 'Es Teh Kampul', 'harga' => 5000],
            ['kategori' => 3, 'nama' => 'Kopi Susu Aren', 'harga' => 13000],
            ['kategori' => 3, 'nama' => 'Es Jeruk Peras', 'harga' => 6000],
        ];

        $produkIds = [];
        foreach ($menuData as $menu) {
            $produkIds[] = DB::table('produks')->insertGetId([
                'id_seller' => $sellerId,
                'id_kategori' => $menu['kategori'],
                'nama_produk' => $menu['nama'],
                'deskripsi' => 'Menu andalan KantinQ, rasanya juara!',
                'harga' => $menu['harga'],
                'stok' => rand(20, 100),
                'status' => 'available',
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        // 3. SIAPKAN CUSTOMER
        DB::table('profil_customers')->updateOrInsert(
            ['id' => 999],
            ['user_id' => 1, 'name' => 'Mahasiswa Lapar', 'phone' => '0812345678', 'created_at' => $now]
        );

        // 4. SUNTIK PESANAN (Kombinasi Menu)
        $statuses = [
            'baru' => 5,         
            'diproses' => 4,     
            'siap_diambil' => 3, 
            'selesai' => 8       
        ];

        foreach ($statuses as $status => $jumlah) {
            for ($i = 0; $i < $jumlah; $i++) {
                
                // Buat order dulu, harga diset 0 karena kita belum tahu dia beli apa saja
                $orderId = DB::table('orders')->insertGetId([
                    'id_seller' => $sellerId,
                    'total_amount' => 0, 
                    'status' => $status,
                    'created_at' => $now->copy()->subMinutes(rand(1, 180)), 
                    'updated_at' => $now
                ]);

                // Acak pembeli ini mau beli berapa macam menu (1 sampai 3 macam)
                $macamMenu = rand(1, 3);
                $totalHargaPesanan = 0;

                // Ambil menu secara acak
                $keysMenuPilihan = array_rand($produkIds, $macamMenu);
                if (!is_array($keysMenuPilihan)) {
                    $keysMenuPilihan = [$keysMenuPilihan]; // Format ulang kalau dia cuma beli 1 macam
                }

                foreach ($keysMenuPilihan as $pIndex) {
                    $qty = rand(1, 2); // Dia beli 1 atau 2 porsi untuk menu ini
                    $hargaSatuan = $menuData[$pIndex]['harga'];
                    $subTotal = $hargaSatuan * $qty;
                    $totalHargaPesanan += $subTotal;

                    DB::table('order_items')->insert([
                        'order_id' => $orderId,
                        'id_produk' => $produkIds[$pIndex],
                        'id_profil_customer' => 999,
                        'quantity' => $qty,
                        'price' => $hargaSatuan,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }

                // Update total harga sesuai jumlah makanan yang dibeli
                DB::table('orders')->where('id', $orderId)->update([
                    'total_amount' => $totalHargaPesanan
                ]);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->command->info('SUKSES! KantinQ ID 14 sudah penuh dengan menu yang bervariasi.');
    }
}
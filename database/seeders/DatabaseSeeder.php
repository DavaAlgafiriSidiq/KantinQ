<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ambil tanggal hari ini persis jam 00:00:00
        $today = Carbon::today();

        // 1. Buat Data Toko Utama
        $store = Store::create([
            'name' => 'Kantin Ibu Yati',
            'is_open' => true,
        ]);

        // 2. Buat Data Menu
        $menuAyam = Menu::create(['store_id' => $store->id, 'name' => 'Ayam Geprek', 'price' => 15000, 'is_active' => true]);
        $menuEsTeh = Menu::create(['store_id' => $store->id, 'name' => 'Es Teh Manis', 'price' => 4000, 'is_active' => true]);
        $menuIndomie = Menu::create(['store_id' => $store->id, 'name' => 'Indomie Telur Kornet', 'price' => 12000, 'is_active' => true]);
        $menuNasgor = Menu::create(['store_id' => $store->id, 'name' => 'Nasi Goreng Spesial', 'price' => 18000, 'is_active' => true]);

        // 3. Buat Transaksi Pesanan (Diset ke hari ini agar muncul di Dashboard)

        // Pesanan 1: Selesai (Nanti masuk ke total pendapatan)
        $order1 = Order::create([
            'store_id' => $store->id, 
            'total_amount' => 34000, 
            'status' => 'selesai', 
            'created_at' => $today, 
            'updated_at' => $today
        ]);
        OrderItem::create(['order_id' => $order1->id, 'menu_id' => $menuAyam->id, 'quantity' => 2, 'price' => 15000]);
        OrderItem::create(['order_id' => $order1->id, 'menu_id' => $menuEsTeh->id, 'quantity' => 1, 'price' => 4000]);

        // Pesanan 2: Selesai
        $order2 = Order::create([
            'store_id' => $store->id, 
            'total_amount' => 12000, 
            'status' => 'selesai', 
            'created_at' => $today, 
            'updated_at' => $today
        ]);
        OrderItem::create(['order_id' => $order2->id, 'menu_id' => $menuIndomie->id, 'quantity' => 1, 'price' => 12000]);

        // Pesanan 3: Siap Diambil 
        $order3 = Order::create([
            'store_id' => $store->id, 
            'total_amount' => 22000, 
            'status' => 'siap_diambil', 
            'created_at' => $today, 
            'updated_at' => $today
        ]);
        OrderItem::create(['order_id' => $order3->id, 'menu_id' => $menuNasgor->id, 'quantity' => 1, 'price' => 18000]);
        OrderItem::create(['order_id' => $order3->id, 'menu_id' => $menuEsTeh->id, 'quantity' => 1, 'price' => 4000]);

        // Pesanan 4: Baru
        $order4 = Order::create([
            'store_id' => $store->id, 
            'total_amount' => 15000, 
            'status' => 'baru', 
            'created_at' => $today, 
            'updated_at' => $today
        ]);
        OrderItem::create(['order_id' => $order4->id, 'menu_id' => $menuAyam->id, 'quantity' => 1, 'price' => 15000]);
        
        // Pesanan 5: Diproses
        $order5 = Order::create([
            'store_id' => $store->id, 
            'total_amount' => 30000, 
            'status' => 'diproses', 
            'created_at' => $today, 
            'updated_at' => $today
        ]);
        OrderItem::create(['order_id' => $order5->id, 'menu_id' => $menuAyam->id, 'quantity' => 2, 'price' => 15000]);
    }
}
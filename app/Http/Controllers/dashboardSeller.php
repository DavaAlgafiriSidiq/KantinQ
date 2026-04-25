<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $storeId = 1; // Contoh ID toko, nantinya bisa diambil dari session/auth

        // AC 1: Total pendapatan hari ini
        $totalPendapatan = Order::where('store_id', $storeId)
            ->whereDate('created_at', $today)
            ->where('status', 'selesai')
            ->sum('total_amount');

        // AC 2: Pesanan sukses hari ini
        $pesananSelesai = Order::where('store_id', $storeId)
            ->whereDate('created_at', $today)
            ->where('status', 'selesai')
            ->count();

        // AC 3: Top 3 Menu Terlaris hari ini
        $topMenus = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->whereDate('orders.created_at', $today)
            ->select('menus.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('menus.id', 'menus.name')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();

        // AC 6: Hitung pesanan berdasarkan status
        $statusCounts = Order::where('store_id', $storeId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $toko = Store::find($storeId);

        return view('seller.dashboard', compact(
            'totalPendapatan', 
            'pesananSelesai', 
            'topMenus', 
            'statusCounts', 
            'toko'
        ));
    }

    // Fungsi untuk Switch Buka/Tutup Toko
    public function toggleStatus(Request $request, $id)
    {
        $toko = Store::findOrFail($id);
        $toko->is_open = !$toko->is_open;
        $toko->save();

        return back()->with('success', 'Status operasional berhasil diubah!');
    }
}
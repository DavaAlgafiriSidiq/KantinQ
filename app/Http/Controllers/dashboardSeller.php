<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\AkunSellerModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class dashboardSeller extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $seller = Auth::guard('seller')->user(); // Ambil data seller yang login
        $sellerId = $seller->id;

        // PERBAIKAN 1: Ganti 'user' jadi 'profilCustomer'
        $riwayatPesanan = Order::with('profilCustomer')
            ->where('id_seller', $sellerId)
            ->orderBy('created_at', 'desc')
            ->get();

        $isTokoBuka = $seller->is_open; // Ambil status dari tabel seller

        // AC 1: Total pendapatan hari ini
        $totalPendapatan = Order::where('id_seller', $sellerId)
             ->whereDate('created_at', $today)
             ->where('status', 'selesai')
            ->sum('total_amount'); 

        // AC 2: Pesanan sukses hari ini
        $pesananSelesai = Order::where('id_seller', $sellerId)
            ->whereDate('created_at', $today)
            ->where('status', 'selesai')
            ->count();

        // AC 3: Top 3 Menu Terlaris hari ini
        $topMenus = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('produks', 'order_items.id_produk', '=', 'produks.id') 
            ->where('orders.id_seller', $sellerId)
            ->whereDate('orders.created_at', $today)
            // PERBAIKAN 2: Ganti 'stok' jadi 'quantity'
            ->select('produks.nama_produk as name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('produks.id', 'produks.nama_produk')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();

        // Hitung pesanan berdasarkan status statis
        $pesananBaru = Order::where('id_seller', $sellerId)->where('status', 'baru')->count();
        $pesananDiproses = Order::where('id_seller', $sellerId)->where('status', 'diproses')->count();
        $pesananSiap = Order::where('id_seller', $sellerId)->where('status', 'siap_diambil')->count();

        return view('session-seller.master', compact(
            'totalPendapatan', 'pesananSelesai', 'pesananBaru',
            'pesananDiproses', 'pesananSiap', 'isTokoBuka',
            'topMenus', 'seller', 'riwayatPesanan'
        ));
    }

    // Fungsi Switch Buka/Tutup Toko
    public function toggleStatus(Request $request)
    {
        $seller = AkunSellerModel::findOrFail(Auth::guard('seller')->id());
        $seller->is_open = !$seller->is_open;
        $seller->save();

        return back()->with('success', 'Status operasional berhasil diubah!');
    }

    // Polling Daftar Order Real-time
    public function getOrderData(Request $request)
    {
        $sellerId = Auth::guard('seller')->id();
        $statusFilter = $request->query('status');

        $query = Order::with('orderItems.menu') // Detail menu
            ->where('id_seller', $sellerId)
            ->whereIn('status', ['baru', 'diproses', 'siap_diambil']);

        if ($statusFilter && $statusFilter !== 'semua') {
            $query->where('status', $statusFilter);
        }

        // Urutkan terlama ke terbaru (Ascending)
        $orders = $query->orderBy('created_at', 'asc')->get();

        // Kalkulasi Estimasi Waktu (Asumsi 1 antrean = 5 menit)
        $queueCount = 0;
        $orders->transform(function ($order) use (&$queueCount) {
            if (in_array($order->status, ['baru', 'diproses'])) {
                $queueCount++;
                $order->eta = $queueCount * 5; 
            } else {
                $order->eta = 0;
            }
            $order->time_formatted = $order->created_at->format('H:i');
            return $order;
        });

        $baruCount = $orders->where('status', 'baru')->count();

        return response()->json([
            'orders' => $orders,
            'baru_count' => $baruCount
        ]);
    }

    // Update Status 
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::where('id_seller', Auth::guard('seller')->id())->findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true]);
    }
}
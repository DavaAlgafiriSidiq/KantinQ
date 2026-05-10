<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\AkunSellerModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\produk;

class dashboardSeller extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $sellerId = Auth::guard('seller')->id();
        
        // Ambil data seller terbaru langsung dari DB agar is_open 
        $seller = AkunSellerModel::findOrFail($sellerId);
        $isTokoBuka = $seller->is_open; 

        $riwayatPesanan = Order::with('profilCustomer')
            ->where('id_seller', $sellerId)
            ->orderBy('created_at', 'desc')
            ->get();

        $isTokoBuka = $seller->is_open; // Ambil status dari tabel seller


        // 1. Hitung Pendapatan hanya dari yang statusnya 'selesai'
        $totalPendapatan = Order::where('id_seller', $sellerId)
            ->where('status', 'selesai')
            ->sum('total_amount');

        // 2. Hitung Pesanan yang sudah Selesai
        $pesananSelesai = Order::where('id_seller', $sellerId)
            ->where('status', 'selesai')
            ->count();

        // 3. Ambil Top 3 Menu (Hitung dari order_items)
        $topMenus = DB::table('order_items')
            ->join('produks', 'order_items.id_produk', '=', 'produks.id')
            ->select('produks.nama_produk as name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->where('produks.id_seller', $sellerId)
            ->groupBy('produks.id', 'produks.nama_produk')
            ->orderBy('total_sold', 'desc')
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
        $sellerId = Auth::guard('seller')->id();
        // Gunakan update langsung ke DB agar lebih pasti
        $seller = AkunSellerModel::findOrFail($sellerId);
        $statusBaru = ($seller->is_open == 1) ? 0 : 1;
        
        $seller->update(['is_open' => $statusBaru]);

        return back()->with('success', 'Status operasional berhasil diperbarui!');
    }
        
    // Polling Daftar Order Real-time
    public function getOrderData(Request $request)
    {
        $sellerId = Auth::guard('seller')->id();
        $statusFilter = $request->query('status');

        $query = \App\Models\Order::with('orderItems.produk') 
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


        return response()->json([
            'orders' => $orders,
            'baru_count' => $orders->where('status', 'baru')->count()
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

    public function checkIncomingOrders()
    {
        $sellerId = auth('seller')->id();
        
        $orders = \App\Models\Order::where('id_seller', $sellerId)
                    ->where('status', 'baru') // Hanya ambil yang statusnya masih baru
                    ->with('profilCustomer')
                    ->latest()
                    ->get();

        return response()->json([
            'count' => $orders->count(),
            'orders' => $orders
        ]);
    }
        
}
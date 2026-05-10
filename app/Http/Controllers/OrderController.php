<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Fitur Riwayat untuk Customer
    public function historyCustomer()
    {
        // AC: Urut waktu terbaru & Filter berdasarkan user yang login
        $orders = Order::with('orderItems.produk')
            ->where('id_profil_customer', Auth::user()->id) // Pastikan field ini sesuai dengan ID loginmu
            ->orderBy('created_at', 'desc')
            ->get();

        return view('session-customer.history', compact('orders'));
    }

    // Fitur Riwayat untuk Seller
    public function historySeller(Request $request)
    {
        $query = Order::with('orderItems.produk', 'profilCustomer')
            ->where('id_seller', Auth::user()->id);

        // AC: Filter tanggal (Harian/Mingguan/Bulanan)
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        // AC: Akumulasi Penjualan
        $totalPendapatan = $orders->where('status', 'selesai')->sum('total_amount');
        $totalPesanan = $orders->where('status', 'selesai')->count();

        return view('seller.history', compact('orders', 'totalPendapatan', 'totalPesanan'));
    }

    // Fitur Update Status (Untuk Seller)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status; // AC: baru, diproses, siap_diambil, selesai, dibatalkan
        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\keranjang;
use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // =================================================================
    // BAGIAN CUSTOMER
    // =================================================================

    // Fitur Riwayat untuk Customer
    public function historyCustomer()
    {
        $user = Auth::user();
        $customer = $user->profilCustomer; 

        // Urut waktu terbaru
        $orders = Order::with('orderItems.produk')
            ->where('id_profil_customer', $customer->id ?? Auth::id()) 
            ->orderBy('created_at', 'desc')
            ->get();

        return view('session-customer.history', compact('orders'));
    }

    // Fitur Pesan Lagi 
    public function pesanLagi($id)
    {
        $user = Auth::user();
        $customer = $user->profilCustomer;

        $order = Order::with('orderItems')->findOrFail($id);

        foreach ($order->orderItems as $item) {
            $produk = produk::find($item->id_produk);
            
            // Hanya masukkan ke keranjang jika produk masih ada dan tersedia
            if ($produk && $produk->status == 'available' && $produk->stok > 0) {
                $keranjangAda = keranjang::where('id_profil_customer', $customer->id)
                                         ->where('id_produk', $item->id_produk)
                                         ->first();

                if ($keranjangAda) {
                    $keranjangAda->increment('jumlah', $item->quantity); 
                } else {
                    keranjang::create([
                        'id_profil_customer' => $customer->id,
                        'id_produk' => $item->id_produk,
                        'id_seller' => $item->id_seller,
                        'jumlah' => $item->quantity, 
                    ]);
                }
            }
        }

        return redirect()->route('keranjang')->with('success_masuk', 'Menu dari pesanan lama berhasil ditambahkan ke keranjang!');
    }

    //Download Invoice Customer
    public function downloadInvoice($id)
    {
        $order = Order::with(['orderItems.produk', 'profilCustomer'])->findOrFail($id);

        if ($order->status !== 'selesai') {
            return back()->with('error', 'Struk hanya untuk pesanan yang sudah selesai.');
        }

        $pdf = Pdf::loadView('session-customer.invoice', compact('order'));
        return $pdf->download('Invoice_KantinQ_' . $order->kode_pesanan . '.pdf');
    }


    // =================================================================
    // BAGIAN SELLER
    // =================================================================

    // Fitur Riwayat untuk Seller
    public function historySeller(Request $request)
    {
        $sellerId = Auth::guard('seller')->id() ?? Auth::id();

        $query = Order::with(['orderItems.produk', 'profilCustomer'])
            ->where('id_seller', $sellerId);

        //  Pencarian ID Pesanan Spesifik
        if ($request->has('search_id') && $request->search_id != '') {
            $query->where('kode_pesanan', 'like', '%' . $request->search_id . '%');
        }

        // Filter tanggal (Harian/Mingguan/Bulanan)
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date != '') {
            // Pastikan format waktunya mencakup awal hari dan akhir hari
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        // Akumulasi Penjualan & Jumlah Pesanan
        $totalPendapatan = $orders->where('status', 'selesai')->sum('total_amount');
        $totalPesanan = $orders->where('status', 'selesai')->count();

        // Mengunduh Laporan Pembukuan Seller
        if ($request->has('download_pdf')) {
            $pdf = Pdf::loadView('session-seller.laporan-pdf', compact('orders', 'totalPendapatan', 'totalPesanan', 'request'));
            return $pdf->download('Laporan_Penjualan_KantinQ_' . now()->format('Ymd') . '.pdf');
        }

        return view('session-seller.history', compact('orders', 'totalPendapatan', 'totalPesanan'));
    }

    // Fitur Update Status (Untuk Seller)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status; 

        // Sistem mencatat waktu setiap perubahan status
        if ($request->status == 'diproses') {
            $order->processed_at = now();
        } elseif ($request->status == 'siap_diambil') {
            $order->ready_at = now();
        } elseif ($request->status == 'selesai') {
            $order->completed_at = now();
        }

        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
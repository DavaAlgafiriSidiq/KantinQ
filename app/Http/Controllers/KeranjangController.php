<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;
use App\Models\keranjang;
use App\Models\AkunCustomer;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function tambahKeKeranjang(Request $request, int $id) {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login dulu');
        }

        $user = Auth::user();
        $customer = $user->profilCustomer ?: $user->profilCustomer()->create(['name' => $user->name]);
        
        // Ambil data produk
        $produk = produk::findOrFail($id);

        // --- VALIDASI BARU DI SINI ---
        // 1. Cek apakah status produk 'unavailable'
        if ($produk->status == 'unavailable') {
            return redirect()->back()->with('error', 'Maaf, menu ini sedang tidak tersedia untuk dipesan.');
        }

        // 2. Cek apakah stok produk 0 atau kurang
        if ($produk->stok <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok menu ini sudah habis.');
        }

        $itemAda = keranjang::where('id_profil_customer', $customer->id)
                            ->where('id_produk', $id)
                            ->first();

        if ($itemAda) {
            // Cek juga agar penambahan tidak melebihi stok yang ada
            if ($itemAda->jumlah + 1 > $produk->stok) {
                return redirect()->back()->with('error', 'Jumlah di keranjang sudah mencapai batas stok yang tersedia.');
            }
            $itemAda->update(['jumlah' => $itemAda->jumlah + 1]);
        } else {
            keranjang::create([
                'id_profil_customer' => $customer->id,
                'id_produk' => $id,
                'id_seller' => $produk->id_seller,
                'jumlah' => 1,
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->back()->with('success_masuk', 'Menu berhasil masuk keranjang!');
    }

    public function tampilkanKeranjang()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $profil = $user->profilCustomer; 
        
        if (!$profil) {
            // JANGAN PAKAI back(), arahkan langsung ke profil biar user tahu harus ngapain
            return redirect()->route('profil-customer.index')->with('error', 'Lengkapi profil dulu ya.');
        }

        $keranjang = keranjang::with(['produk', 'seller'])
                            ->where('id_profil_customer', $profil->id)
                            ->get();

        return view('session-customer.keranjang', compact('keranjang'));
    }

    public function hapusItem(int $id) {
        $user = Auth::user();
        $profil = $user->profilCustomer; 

        if (!$profil) {
             return redirect()->back()->with('error', 'Profil tidak ditemukan.');
        }

        $item = keranjang::where('id', $id)
                    ->where('id_profil_customer', $profil->id)
                    ->firstOrFail();

        $item->delete();
        return redirect()->back()->with('success', 'Item dihapus dari keranjang');
    }

    public function updateJumlah(Request $request, int $id) 
    {
        $item = keranjang::with('produk')->findOrFail($id);
        $action = $request->input('action');

        if ($action === 'increase') {
            if ($item->jumlah + 1 > $item->produk->stok) {
                return response()->json(['error' => 'Stok tidak mencukupi'], 400);
            }
            $item->increment('jumlah');
        } elseif ($action === 'decrease') {
            if ($item->jumlah > 1) {
                $item->decrement('jumlah');
            } else {
                // JIKA JUMLAH SUDAH 1 DAN DIKURANGI -> HAPUS DARI DATABASE
                $item->delete();
                
                // Hitung ulang total keranjang setelah satu item dihapus
                $totalKeranjang = keranjang::where('id_profil_customer', $item->id_profil_customer)
                                    ->get()
                                    ->sum(fn($i) => $i->jumlah * $i->produk->harga);

                return response()->json([
                    'success' => true,
                    'removed' => true, // Beri tanda kalau item dihapus
                    'totalKeranjang' => number_format($totalKeranjang, 0, ',', '.')
                ]);
            }
        }

        // Hitung ulang subtotal dan total jika item TIDAK dihapus
        $newSubtotalItem = $item->jumlah * $item->produk->harga;
        $totalKeranjang = keranjang::where('id_profil_customer', $item->id_profil_customer)
                            ->get()
                            ->sum(fn($i) => $i->jumlah * $i->produk->harga);

        return response()->json([
            'success' => true,
            'removed' => false,
            'jumlah' => $item->jumlah,
            'newSubtotalItem' => number_format($newSubtotalItem, 0, ',', '.'),
            'totalKeranjang' => number_format($totalKeranjang, 0, ',', '.')
        ]);
    }
}
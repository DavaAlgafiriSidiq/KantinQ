<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;
use App\Models\keranjang;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function tambahKeKeranjang(Request $request, int $id) {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login dulu');
        }

        $produk = produk::findOrFail($id);
        
        // PASTIIN PAKAI 'profil' (sesuai Model AkunCustomer)
        $customer = Auth::user()->profil;

        if (!$customer) {
            return redirect()->back()->with('error', 'Profil belum lengkap. Silakan isi profil di menu My Profile.');
        }

        $itemAda = keranjang::where('id_profil_customer', $customer->id)
                            ->where('id_produk', $id)
                            ->first();

        if ($itemAda) {
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

        return redirect()->back()->with('success', 'Berhasil ditambah ke keranjang!');
    }

    public function tampilkanKeranjang()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $profil = $user->profil; // Pakai 'profil'
        
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
        $profil = $user->profil; // Pakai 'profil'

        if (!$profil) {
             return redirect()->back()->with('error', 'Profil tidak ditemukan.');
        }

        $item = keranjang::where('id', $id)
                    ->where('id_profil_customer', $profil->id)
                    ->firstOrFail();

        $item->delete();
        return redirect()->back()->with('success', 'Item dihapus dari keranjang');
    }
}
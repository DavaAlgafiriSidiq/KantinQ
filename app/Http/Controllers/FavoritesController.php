<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $favorites = Favorite::with(['produk'])
            ->where('id_user', $user->id)
            ->latest()
            ->get();

        return view('session-customer.favorite-customer.index', compact('favorites'));
    }

    public function toggleFavorite(Request $request, $id_produk)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $customer = $user->profilCustomer; 
        if (!$customer) {
            return back()->with('error', 'Profil customer tidak ditemukan. Lengkapi profil Anda terlebih dahulu.');
        }

        $orderPernahDibeli = Order::where('id_profil_customer', $customer->id)
            ->whereHas('orderItems', function ($query) use ($id_produk) {
                $query->where('id_produk', $id_produk);
            })
            ->exists();

        if (!$orderPernahDibeli) {
            return back()->with('error', 'Anda hanya dapat memfavoritkan menu yang sudah pernah Anda pesan sebelumnya.');
        }

        // Logika Toggle
        $favorite = Favorite::where('id_user', $user->id)
                            ->where('id_produk', $id_produk)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            $pesan = 'Menu berhasil dihapus dari favorit!';
        } else {
            Favorite::create([
                'id_user'   => $user->id,
                'id_produk' => $id_produk,
                'id_order'  => $request->id_order ?? null 
            ]);
            $pesan = 'Menu berhasil ditambahkan ke favorit!';
        }

        // Redirect
        if ($request->has('id_order')) {
            return redirect()->route('favorites.index')->with('success', $pesan);
        }

        return back()->with('success', $pesan);
    }

    public function destroy($id)
    {
        $favorite = Favorite::where('id', $id)
            ->where('id_user', Auth::id())
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Menu telah dihapus dari daftar favorit.');
        }

        return back()->with('error', 'Gagal menghapus favorit atau data tidak ditemukan.');
    }
}
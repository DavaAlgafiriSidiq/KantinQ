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
        
        // Mengambil data favorit milik user yang sedang login
        $favorites = Favorite::with(['produk', 'order'])
                    ->where('id_user', $user->id)
                    ->latest()
                    ->get();

        return view('session-customer.favorite-customer.index', compact('favorites'));
    }

    public function toggleFavorite(Request $request, $id_produk) {
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login dulu.');
    }

        $user = Auth::user();
        
        $orderId = $request->id_order;

        if (!$orderId) {
            $lastOrder = Order::where('id_user', $user->id)->latest()->first();
            
            if (!$lastOrder) {
                $anyOrder = Order::first();
                if (!$anyOrder) {
                    return back()->with('error', 'Sistem belum siap. Belum ada transaksi di aplikasi ini.');
                }
                $orderId = $anyOrder->id;
            } else {
                $orderId = $lastOrder->id;
            }
        }

        Favorite::updateOrCreate(
            [
                'id_user'   => $user->id,
                'id_produk' => $id_produk,
            ],
            [
                'id_order'  => $orderId 
            ]
        );

        if ($request->has('id_order')) {
            return redirect()->route('favorites.index')->with('success', 'Menu berhasil jadi favorit!');
        }

        return back()->with('success', 'Berhasil memperbarui favorit!');
    }

    public function destroy($id)
    {
        Favorite::where('id', $id)->where('id_user', Auth::id())->delete();
        return back()->with('success', 'Berhasil dihapus.');
    }
}
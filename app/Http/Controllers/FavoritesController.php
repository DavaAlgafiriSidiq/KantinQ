<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite; 
use App\Models\Order; // Tambahkan ini untuk mencari order
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorites = Favorite::with(['produk', 'order'])
                    ->where('id_user', $user->id)
                    ->latest()
                    ->get();

        return view('session-customer.favorite-customer.index', compact('favorites'));
    }

    public function toggleFavorite(Request $request, $id_produk)
    {
        $user = Auth::user();
        
        // Cek apakah ada id_order dari request (dari halaman checkout sukses)
        $orderId = $request->id_order;

        // Jika tidak ada id_order (klik dari halaman menu), cari ID order terakhir user tersebut
        if (!$orderId) {
            $lastOrder = Order::where('id_user', $user->id)->latest()->first();
            
            // Jika user belum pernah belanja sama sekali (tidak punya order), 
            // maka fitur favorit belum bisa digunakan karena constraint database kamu.
            if (!$lastOrder) {
                return back()->with('error', 'Silahkan lakukan pemesanan pertama Anda sebelum menambah favorit.');
            }
            
            $orderId = $lastOrder->id;
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
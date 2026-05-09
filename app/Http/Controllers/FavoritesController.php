<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite; 
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    /**
     * Menampilkan daftar menu favorit user
     */
    public function index()
    {
        $user = Auth::user();
        
        $favorites = Favorite::with(['produk', 'order'])
                    ->where('id_user', $user->id)
                    ->latest()
                    ->get();

        return view('session-customer.favorite-customer.index', compact('favorites'));
    }

    /**
     * Menyimpan atau memperbarui favorit dari halaman checkout
     */
    public function toggleFavorite(Request $request, $id_produk)
    {
        $user = Auth::user();
        
        Favorite::updateOrCreate(
            [
                'id_user'   => $user->id,
                'id_produk' => $id_produk,
            ],
            [
                'id_order'  => $request->id_order 
            ]
        );

        return redirect()->route('favorites.index')->with('success', 'Menu berhasil ditambahkan ke favorit!');
    }

    /**
     * Menghapus menu dari daftar favorit
     */
    public function destroy($id)
    {
        Favorite::where('id', $id)->where('id_user', Auth::id())->delete();
        return back()->with('success', 'Berhasil dihapus.');
    }
}
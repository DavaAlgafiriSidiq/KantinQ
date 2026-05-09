<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function toggleFavorite(Request $request, $produk_id)
    {
        $user = Auth::user();
        
        // Simpan favorit dengan referensi Order ID dari checkout
        Favorite::updateOrCreate([
            'user_id'   => $user->id,
            'produk_id' => $produk_id,
            'order_id'  => $request->order_id // Diambil dari data checkout sukses
        ]);

        return redirect()->route('favorites.index')->with('success', 'Menu checkout berhasil jadi favorit!');
    }
}
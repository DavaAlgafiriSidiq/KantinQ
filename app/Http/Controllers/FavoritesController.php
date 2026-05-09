<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite; // Pastikan nama file di Models sudah Favorite.php (F besar)
use App\Models\produk;   // Tambahkan ini jika ingin validasi produk
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // menampilkan halaman favorit
    public function index()
    {
        $user = Auth::user();
                $favorites = Favorite::with(['produk', 'order'])
                    ->where('user_id', $user->id)
                    ->latest()
                    ->get();

        return view('session-customer.favorites.index', compact('favorites'));
    }

    public function toggleFavorite(Request $request, $produk_id)
    {
        $user_id = Auth::id(); 
        
        // updateOrCreate untuk mencegah duplikasi data yang sama
        // Jika user memfavoritkan produk yang sama dari order yang berbeda
        Favorite::updateOrCreate(
            [
                'user_id'   => $user_id,
                'produk_id' => $produk_id,
            ],
            [
                'order_id'  => $request->order_id
            ]
        );

        return redirect()->route('favorites.index')->with('success', 'Menu berhasil ditambahkan ke favorit!');
    }

    // fungsi destroy untuk menghapus favorit
    public function destroy($id)
    {
        $favorite = Favorite::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $favorite->delete();

        return back()->with('success', 'Berhasil dihapus dari favorit.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\produk;


class RatingController extends Controller
{
// Method untuk menampilkan form rating dan ulasannya   
public function create($id)
{
    $produk = produk::findOrFail($id);

    return view('session-customer.rating-customer.rating', compact('produk'));
}

// Method untuk menyimpan rating dan ulasan ke database
public function store(Request $request)
{
    $request->validate([
        'produk_id' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'ulasan' => 'nullable|string'
    ]);

    Rating::create([
        'user_id' => auth()->id(),
        'produk_id' => $request->produk_id,
        'rating' => $request->rating,
        'ulasan' => $request->ulasan,
    ]);

    return redirect('/menu')->with('success', 'Rating berhasil dikirim');
}

}

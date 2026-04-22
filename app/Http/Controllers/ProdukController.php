<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = produk::latest()->paginate(10);
        return view('session-seller.seller-produk', compact('produk'));
    }

    public function sellerProduk()
    {
        // Memanggil file view seller-form-new-produk.blade.php yang ada di dalam folder resources/views/session-seller/
        return view('session-seller.seller-produk');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Memanggil file view seller-form-new-produk.blade.php yang ada di dalam folder resources/views/session-seller/
        return view('session-seller.seller-form-new-produk');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        return view('session-seller.seller-edit-produk');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        //
    }
}

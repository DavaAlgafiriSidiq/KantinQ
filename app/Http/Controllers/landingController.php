<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;

class LandingController extends Controller
{
    public function menu()
        {
            // Ambil produk beserta relasi seller dan kategori
            $query = Produk::with(['seller', 'kategori']);

            // Kalau user memilih kategori
            if (request()->filled('kategori')) {

                // Filter produk berdasarkan kategori
                $query->where('id_kategori', request('kategori'));
            }

            // Ambil data produk
            $products = $query->latest()->get();

            // Ambil semua kategori untuk dropdown
            $categories = Kategori::all();

            return view('session-customer.menu', compact('products', 'categories'));
        }
}


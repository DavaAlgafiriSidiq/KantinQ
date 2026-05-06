<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class LandingController extends Controller
{
    public function menu()
    {
        // Mengambil semua produk beserta data seller-nya (eager loading)
        $products = Produk::with('seller')->latest()->get();

        return view('session-customer.menu', compact('products'));
    }
}


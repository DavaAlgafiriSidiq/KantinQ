<?php

use App\Http\Controllers\AkunSellerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// REGISTRASI UMUM (Customer & Seller)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
    Route::post('/register', [RegisterController::class, 'processRegistration']);
});

// Tampilan Untuk Seller (Dashboard)
Route::middleware('auth:seller')->controller(AkunSellerController::class)->group(function () {
    // SELLER (DASHBOARD)
    Route::get('/seller', 'sellerMain');
    Route::get('/seller-produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/seller-tambah-produk', [ProdukController::class, 'create'])->name('produk.create');
    Route::get('/seller-edit-produk/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/seller-update-produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::post('/seller-simpan-produk', [ProdukController::class, 'simpan'])->name('produk.simpan');
    Route::delete('/seller-hapus-produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});

//search menu produk
Route::get('/SearchProduk', [ProdukController::class, 'SearchProduk']);

// Tampilan Login Untuk Seller
Route::middleware('guest:seller')->controller(AkunSellerController::class)->group(function () {
    Route::get('/seller-login', 'sellerLogin')->name('login-seller');
    Route::post('/seller-login', 'sellerLogins');
});

// Untuk Logout Seller
Route::post('/seller-logout', [AkunSellerController::class, 'sellerLogout']);

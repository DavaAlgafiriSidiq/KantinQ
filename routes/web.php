<?php

use App\Http\Controllers\AkunSellerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Tampilan Untuk Seller
Route::middleware('auth:seller')->controller(AkunSellerController::class)->group(function () {
    // SELLER (DASHBOARD)
    Route::get('/seller', 'sellerMain');
});

// Tampilan Login dan Register Untuk Seller
Route::middleware('guest:seller')->controller(AkunSellerController::class)->group(function () {
    // SELLER (LOGIN)
    Route::get('/seller-login', [AkunSellerController::class, 'sellerLogin'])->name('login-seller');
    Route::post('/seller-login', [AkunSellerController::class, 'sellerLogins']);
    // SELLER (REGISTER)
    Route::get('/seller-register', [AkunSellerController::class, 'sellerRegister']);
    Route::post('/seller-register', [AkunSellerController::class, 'sellerRegisters']);
});

// Untuk Logout Seller
Route::post('/seller-logout', [AkunSellerController::class, 'sellerLogout']);

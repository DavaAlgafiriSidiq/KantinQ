<?php

use App\Http\Controllers\AkunSellerController;
use App\Http\Controllers\RegisterController;
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
});

// Tampilan Login Untuk Seller
Route::middleware('guest:seller')->controller(AkunSellerController::class)->group(function () {
    Route::get('/seller-login', 'sellerLogin')->name('login-seller');
    Route::post('/seller-login', 'sellerLogins');
});

// Untuk Logout Seller
Route::post('/seller-logout', [AkunSellerController::class, 'sellerLogout']);

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AkunSellerModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AkunSellerController extends Controller
{
    // Untuk Menampilkan Tampilan Dashboard Seller
    public function sellerMain()
    {
        // Memanggil file view seller-main.blade.php yang ada di dalam folder resources/views/session-seller/
        return view('session-seller.seller-main');
    }

    // Untuk Menampilkan Tampilan Register Seller
    public function sellerRegister()
    {
        return view('session-seller/seller-register');
    }

    // Untuk Menampilkan Tampilan Login Seller
    public function sellerLogin()
    {
        return view('session-seller/seller-login');
    }

    // Fungsi untuk proses register seller
    public function sellerRegisters(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:seller,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $seller = AkunSellerModel::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->intended('/seller')->with('success', 'Akun Berhasil Dibuat!');
    }

    // Fungsi untuk proses login seller
    public function sellerLogins(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::guard('seller')->attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->intended('/seller');
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ]);
    }

    // Fungsi untuk proses logout seller
    public function sellerLogout(Request $request)
    {
        Auth::guard('seller')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/seller-login');
    }
}

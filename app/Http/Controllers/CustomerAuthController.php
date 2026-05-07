<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    // Menampilkan form login untuk customer
    public function showLoginForm()
    {
        return view('session-customer.login-customer');
    }

    // Memproses request login customer
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Attempt login menggunakan default guard (web) yang terhubung dengan tabel users (Model AkunCustomer)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Jika berhasil, arahkan ke beranda belanja
            return redirect()->intended('/menu')->with('success', 'Berhasil login sebagai Customer.');
        }

        // Jika gagal, kembalikan dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses logout customer
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman landing page setelah logout
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}

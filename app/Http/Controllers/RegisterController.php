<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkunSellerModel;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Fungsi untuk menampilkan form pendaftaran (gabungan)
    public function showRegistrationForm()
    {
        // Ubah pemanggilan view karena file berada di dalam folder 'register'
        return view('register.auth-register');
    }

    // Fungsi untuk memproses data pendaftaran
    public function processRegistration(Request $request)
    {
        // Validasi Input Dasar
        $request->validate([
            'role' => 'required|in:customer,seller',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cabang Logika berdasarkan Role
        if ($request->role === 'seller') {

            // Validasi email unik untuk seller
            $request->validate([
                'email' => 'required|email|unique:seller,email',
            ]);

            AkunSellerModel::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect('/seller-login')->with('success', 'Registrasi Berhasil');

        } else {

            // Validasi email unik untuk customer dan logika simpan (Nanti dilanjutkan oleh tim)

        }
    }
}
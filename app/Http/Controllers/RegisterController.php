<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkunSellerModel;
// Menggunakan model AkunCustomer untuk menyimpan data customer
use App\Models\AkunCustomer; 
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
        // Menyimpan data registrasi berdasarkan peran (role) yang dipilih
        if ($request->role === 'seller') {
            
            // Validasi input khusus untuk pendaftaran seller
            $request->validate([
                'username' => 'required', // Nama Toko
                'nomor_hp' => 'required', // Nomor WhatsApp
                'email' => 'required|email|unique:seller,email',
                'password' => 'required|min:8|confirmed',
            ]);

            // Menyimpan data seller ke tabel 'seller'
            AkunSellerModel::create([
                'username' => $request->username,
                'nomor_hp' => $request->nomor_hp,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect('/seller-login')->with('success', 'Registrasi Berhasil');

        } else if ($request->role === 'customer') {

            // Validasi input khusus untuk pendaftaran customer
            $request->validate([
                'username' => 'required', // Nama Pribadi
                'nomor_handphone' => 'required', // Nomor Handphone
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
            ]);

            // Menyimpan data customer ke tabel 'users' menggunakan model AkunCustomer
            AkunCustomer::create([
                'name' => $request->username, // Map username input ke kolom name
                'nomor_handphone' => $request->nomor_handphone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect('/login')->with('success', 'Registrasi Berhasil');

        } else {
            return back()->withErrors(['role' => 'Role tidak valid.']);
        }
    }
}
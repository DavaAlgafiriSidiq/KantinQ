<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkunSellerModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class AkunSellerController extends Controller
{
    // Untuk Menampilkan Tampilan Dashboard Seller
    public function sellerMain()
    {
        // Memanggil file view seller-main.blade.php yang ada di dalam folder resources/views/session-seller/
        return view('session-seller.seller-main');
    }

    // Untuk Menampilkan Tampilan Login Seller
    public function sellerLogin()
    {
        return view('session-seller/seller-login');
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

    // --- Tambahan Fungsi Profil ---

    // Tampil Profil
    public function indexProfil() 
    {
        $seller = Auth::guard('seller')->user();
        return view('session-seller.profil-seller.index', compact('seller'));
    }

    // Edit Profil
    public function editProfil()
    {
        $user = Auth::guard('seller')->user(); 
        return view('session-seller.profil-seller.edit', compact('user'));
    }

    // Update Profil
    public function updateProfil(Request $request) 
    {
        $user = Auth::guard('seller')->user();
        $akun = AkunSellerModel::find($user->id);

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'deskripsi_toko' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:800',
        ]);

        $akun->nama_toko = $request->nama_toko;
        $akun->nomor_hp = $request->nomor_hp;
        $akun->deskripsi_toko = $request->deskripsi_toko;

        if ($request->hasFile('foto_profil')) {
            if ($akun->foto_profil && Storage::disk('public')->exists($akun->foto_profil)) {
                Storage::disk('public')->delete($akun->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profil-seller', 'public');
            $akun->foto_profil = $path;
        }

        $akun->save(); 

        return redirect()->route('profil-seller.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\profilSeller;
use Illuminate\Support\Facades\Storage;
use App\Models\AkunSellerModel;


class ProfilSellerController extends Controller {

    public function index() {
        $user = Auth::guard('seller')->user(); 
        return view('profilSeller.index', compact('user')); 
    }

        public function edit()
    {
        $user = Auth::guard('seller')->user();

        // Jika user tidak ditemukan, arahkan ke login 
        if (!$user) {
            return redirect('/seller-login')->with('error', 'Sesi habis, silakan login kembali.');
        }
        return view('profilSeller.edit', compact('user'));
    }

        public function updateProfil(Request $request) {
    $seller = Auth::guard('seller')->user();
    
    $request->validate([
        'nama_toko' => 'required|string|max:255',
        'nomor_hp' => 'required|string|max:15',
        'deskripsi_toko' => 'nullable|string',
        'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:800', // Validasi foto
    ]);

    $akun = AkunSellerModel::find($seller->id);
    
    // Data teks
    $data = [
        'nama_toko' => $request->nama_toko,
        'nomor_hp' => $request->nomor_hp,
        'deskripsi_toko' => $request->deskripsi_toko,
    ];

    // LOGIKA FOTO 
    if ($request->hasFile('foto_profil')) {
        // menghapus foto lama jika ada
        if ($akun->foto_profil) {
            Storage::disk('public')->delete($akun->foto_profil);
        }
        
        // Simpan foto baru ke folder storage/app/public/profil-seller
        $path = $request->file('foto_profil')->store('profil-seller', 'public');
        $data['foto_profil'] = $path;
    }

    $akun->update($data);

    return redirect()->route('profil-seller.index')->with('success', 'Profil berhasil diperbarui!');
}
}
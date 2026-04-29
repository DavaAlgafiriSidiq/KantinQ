<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AkunSellerModel;
use Illuminate\Support\Facades\DB;

class ProfilSellerController extends Controller {

    public function index() {
        $user = Auth::guard('seller')->user(); 
        return view('profilSeller.index', compact('user')); 
    }

    public function edit() {
        $user = Auth::guard('seller')->user();
        if (!$user) {
            return redirect('/seller-login')->with('error', 'Sesi habis, silakan login kembali.');
        }
        return view('profilSeller.edit', compact('user'));
    }

    public function updateProfil(Request $request) {
        $seller = Auth::guard('seller')->user();
        
        // VALIDASI: nomor_hp numeric & foto_profil max 2MB (2048 KB)
        $request->validate([
            'nama_toko'      => 'required',
            'nomor_hp'       => 'required|numeric', 
            'deskripsi_toko' => 'required',
            'foto_profil'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        ], [
            // KETERANGAN ERROR CUSTOM (Sesuai permintaanmu)
            'nomor_hp.numeric'  => 'Nomor WhatsApp wajib berupa angka saja!',
            'foto_profil.max'   => 'Foto melebihi batas maksimal (Maks. 2MB)!',
            'foto_profil.image' => 'File harus berupa gambar (JPG, JPEG, PNG).',
        ]);

        $akun = AkunSellerModel::find($seller->id);
        
        DB::beginTransaction();
        try {
            $akun->nama_toko = $request->nama_toko;
            $akun->nomor_hp = $request->nomor_hp; 
            $akun->deskripsi_toko = $request->deskripsi_toko;

            if ($request->hasFile('foto_profil')) {
                if ($akun->foto_profil && file_exists(public_path($akun->foto_profil))) {
                    unlink(public_path($akun->foto_profil));
                }
                
                $file = $request->file('foto_profil');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Simpan ke folder public/images/profil
                $file->move(public_path('images/profil'), $filename);
                
                // Simpan path relatif ke DB agar asset() bisa membacanya
                $akun->foto_profil = 'images/profil/' . $filename;
            }

            $akun->save();
            DB::commit();

            return redirect()->route('profil-seller.index')->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }
}
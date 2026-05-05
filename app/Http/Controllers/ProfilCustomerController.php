<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AkunCustomer;
use App\Models\ProfilCustomer;
use Illuminate\Support\Facades\DB;

class ProfilCustomerController extends Controller {

    public function index() {
        $user = Auth::user(); 
        return view('profilCustomer.index', compact('user')); 
    }

    public function edit() {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Sesi habis, silakan login kembali.');
        }
        return view('profilCustomer.edit', compact('user'));
    }

    public function updateProfil(Request $request) {
        $user = Auth::user();
        
        $request->validate([
            'name'            => 'required|string|max:255',
            'nomor_handphone' => 'required|numeric', 
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        ], [
            'name.required'            => 'Nama pribadi wajib diisi!',
            'nomor_handphone.required' => 'Nomor handphone wajib diisi!',
            'nomor_handphone.numeric'  => 'Nomor handphone harus berupa angka!',
            'foto.max'                 => 'Foto melebihi batas maksimal (Maks. 2MB)!',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update Tabel Akun (users)
            $user->name = $request->name;
            $user->nomor_handphone = $request->nomor_handphone;
            $user->save();

            // 2. Update atau Buat Tabel Profil
            $profil = ProfilCustomer::find($user->id);
            if (!$profil) {
                $profil = new ProfilCustomer();
                $profil->id = $user->id;
            }

            $profil->name = $request->name;
            $profil->phone = $request->nomor_handphone;

            if ($request->hasFile('foto')) {
                if ($profil->foto && file_exists(public_path($profil->foto))) {
                    unlink(public_path($profil->foto));
                }
                
                $file = $request->file('foto');
                $filename = time() . '_cust_' . $file->getClientOriginalName();
                $file->move(public_path('images/profil_customer'), $filename);
                $profil->foto = 'images/profil_customer/' . $filename;
            }

            $profil->save();
            DB::commit();

            return redirect()->route('profil-customer.index')->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }
}
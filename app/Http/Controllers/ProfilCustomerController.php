<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AkunCustomer; 
use App\Models\ProfilCustomer;
use Illuminate\Support\Facades\File;

class ProfilCustomerController extends Controller 
{
    public function index() 
    {
        $user = Auth::user();
        // Ambil data profil dari tabel profil_customers
        $profile = ProfilCustomer::where('id', $user->id)->first();

        return view('session-customer.profile-customer.index', compact('user', 'profile'));
    }

    public function edit() 
    {
        $user = Auth::user();
        $profile = ProfilCustomer::where('id', $user->id)->first();
        
        return view('session-customer.profile-customer.edit', compact('user', 'profile'));
    }

    public function updateProfil(Request $request) 
{
    $user = Auth::user();
    
    $request->validate([
        'name'            => 'required|string|max:255',
        'nomor_handphone' => 'required', 
        'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    try {
        // 1. Update Nama di tabel users (AkunCustomer)
        $currentUser = \App\Models\AkunCustomer::findOrFail($user->id);
        $currentUser->name = $request->name;
        $currentUser->save(); 

        // 2. Cari data profil lama
        $profile = \App\Models\ProfilCustomer::find($user->id);
        $fotoPath = $profile ? $profile->foto : null;

        // 3. Olah Foto
        if ($request->hasFile('foto')) {
            if ($fotoPath && \Illuminate\Support\Facades\File::exists(public_path($fotoPath))) {
                \Illuminate\Support\Facades\File::delete(public_path($fotoPath));
            }
            $file = $request->file('foto');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('images/profil_customer'), $filename);
            $fotoPath = 'images/profil_customer/' . $filename;
        }

        // 4. SIMPAN KE TABEL profil_customers
        // Kita pakai updateOrInsert versi Query Builder biar lebih "galak" ke SQLite
        \Illuminate\Support\Facades\DB::table('profil_customers')->updateOrInsert(
            ['id' => $user->id], // Cari berdasarkan ID
            [
                'name'       => $request->name,
                'phone'      => $request->nomor_handphone,
                'foto'       => $fotoPath,
                'updated_at' => now(),
                'created_at' => $profile ? $profile->created_at : now(),
            ]
        );

        return redirect()->route('profil-customer.index')->with('success', 'Profil berhasil diperbarui!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
    }
}
}
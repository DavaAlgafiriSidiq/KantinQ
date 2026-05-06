<?php

namespace App\Http\Controllers;

use App\Models\AkunCustomer;
use App\Models\ProfilCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProfilCustomerController extends Controller
{
    /**
     * Menampilkan halaman profil.
     */
    public function index()
    {
        $user = Auth::user();
        // Menggunakan id user untuk mencari data di profil_customers
        $profile = ProfilCustomer::where('user_id', $user->id)->first();

        return view('session-customer.profile-customer.index', compact('user', 'profile'));
    }

    /**
     * Menampilkan halaman form edit profil.
     */
    public function edit()
    {
        $user = Auth::user();
        // Konsisten mencari profil berdasarkan user_id
        $profile = ProfilCustomer::where('user_id', $user->id)->first();

        return view('session-customer.profile-customer.edit', compact('user', 'profile'));
    }

    /**
     * Memproses update profil.
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'            => 'required|string|max:255',
            'nomor_handphone' => 'required',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // 1. Update Nama di tabel users (AkunCustomer)
            $currentUser = AkunCustomer::findOrFail($user->id);
            $currentUser->name = $request->name;
            $currentUser->save();

            // 2. Cari data profil lama berdasarkan user_id
            $profile = ProfilCustomer::where('user_id', $user->id)->first();
            $fotoPath = $profile ? $profile->foto : null;

            // 3. Olah Foto
            if ($request->hasFile('foto')) {
                // Hapus foto fisik yang lama jika ada
                if ($fotoPath && File::exists(public_path($fotoPath))) {
                    File::delete(public_path($fotoPath));
                }

                $file = $request->file('foto');
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                
                // Pindahkan ke public/images/profil_customer
                $file->move(public_path('images/profil_customer'), $filename);
                $fotoPath = 'images/profil_customer/' . $filename;
            }

            // 4. Update atau Insert ke tabel profil_customers
            ProfilCustomer::updateOrInsert(
                ['user_id' => $user->id], // Kunci pencarian
                [
                    'name'       => $request->name,
                    'phone'      => $request->nomor_handphone,
                    'foto'       => $fotoPath,
                    'updated_at' => now(),
                    'created_at' => $profile ? $profile->created_at : now(),
                ]
            );

            DB::commit();
            return redirect()->route('profil-customer.index')->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\produk;
use App\Models\kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = produk::latest()->paginate(10);
        return view('session-seller.seller-produk', compact('produk'));
    }

    public function sellerProduk()
    {
        // Memanggil file view seller-form-new-produk.blade.php yang ada di dalam folder resources/views/session-seller/
        return view('session-seller.seller-produk');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // untuk memanggil nama kategori untuk ditampilkan dalam pilihan kategori
        $kategori = kategori::all();
        return view('session-seller.seller-form-new-produk', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function simpan(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'deskripsi'   => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'foto_produk' => 'image|mimes:jpg,jpeg,png|max:2048', 
        ]);

        DB::beginTransaction();
        try {
            $produk = new produk();
            $produk->id_seller = auth('seller')->user()->id;
            $produk->nama_produk = $request->nama_produk;
            $produk->id_kategori = $request->id_kategori;
            $produk->deskripsi = $request->deskripsi;
            $produk->harga = $request->harga;
            $produk->stok = $request->stok;

            if ($request->hasFile('foto_produk')) {
                $file = $request->file('foto_produk');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Simpan file
                $file->move(public_path('images'), $filename);
                
                // Masukkan ke kolom foto_produk di database
                $produk->foto_produk = '/images/' . $filename;
            }

            $produk->save();

            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produk = produk::findOrFail($id); // Cari produk berdasarkan ID
        $kategori = kategori::all(); // Ambil kategori untuk dropdown
        return view('session-seller.seller-edit-produk', compact('produk', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'deskripsi'   => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'foto_produk' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Pastikan produk milik seller yang sedang login
        $produk = produk::where('id', $id)
                        ->where('id_seller', auth('seller')->user()->id)
                        ->firstOrFail();
        
        DB::beginTransaction();
        try {
            $produk->nama_produk = $request->nama_produk;
            $produk->id_kategori = $request->id_kategori;
            $produk->deskripsi = $request->deskripsi;
            $produk->harga = $request->harga;
            $produk->stok = $request->stok;

            if ($request->hasFile('foto_produk')) {
                // Hapus gambar lama dari folder public
                if ($produk->foto_produk && file_exists(public_path($produk->foto_produk))) {
                    unlink(public_path($produk->foto_produk));
                }
                
                $file = $request->file('foto_produk');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $produk->foto_produk = '/images/' . $filename;
            }

            $produk->save();
            DB::commit();

            return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = produk::where('id', $id)->where('id_seller', auth('seller')->user()->id)->firstOrFail();

        // Hapus file gambar dari folder
        if ($produk->foto_produk && file_exists(public_path($produk->foto_produk))) {
            unlink(public_path($produk->foto_produk));
        }

        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}

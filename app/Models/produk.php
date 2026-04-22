<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $table = 'produks';
    protected $fillable = ['id_seller', 'id_kategori', 'nama_produk', 'deskripsi', 'harga', 'stok', 'status'];
    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori');
    }
    public function seller()
    {
        return $this->belongsTo(AkunSellerModel::class, 'id_seller');
    }

    // Fungsi untuk mendapatkan badge kategori
    public function badgeKategori()
    {
        // Daftar kategori dengan label dan warna badge
        $listKategori = [
            '1' => ['label' => 'Makanan Berat', 'color' => 'danger'],
            '2' => ['label' => 'Camilan', 'color' => 'warning'],
            '3' => ['label' => 'Minuman', 'color' => 'info'],
            '4' => ['label' => 'Lainnya', 'color' => 'dark'], 
        ];

        // Ambil data berdasarkan id_kategori produk
        $kategori = $listKategori[$this->id_kategori] ?? ['label' => 'Tanpa Kategori', 'color' => 'secondary'];;

        // Return HTML Badge
        return '<span class="badge bg-label-' . $kategori['color'] . ' me-1">' . $kategori['label'] . '</span>';
    }
}

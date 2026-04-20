<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $table = 'produks';
    protected $fillable = ['id_seller', 'id_kategori', 'nama_produk', 'deskripsi', 'harga', 'stok'];
    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori');
    }
    public function seller()
    {
        return $this->belongsTo(AkunSellerModel::class, 'id_seller');
    }
}

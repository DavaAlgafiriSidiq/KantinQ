<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\ProdukFactory;

class produk extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        // Arahkan ke file factory yang benar
        return ProdukFactory::new();
    }
    protected $table = 'produks';
    protected $fillable = ['id_seller', 'id_kategori', 'nama_produk', 'deskripsi', 'harga', 'stok', 'status', 'foto_produk'];
    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori');
    }
    public function seller()
    {
        return $this->belongsTo(AkunSellerModel::class, 'id_seller');
    }
    
    public function orderItems()
{
    // Relasi: Satu produk bisa ada di banyak baris order_items
    return $this->hasMany(OrderItem::class, 'id_produk');
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
        $kategori = $listKategori[$this->id_kategori] ?? ['label' => 'Tanpa Kategori', 'color' => 'secondary'];
        

        // Return HTML Badge
        return '<span class="badge bg-label-' . $kategori['color'] . ' me-1">' . $kategori['label'] . '</span>';
    }
}

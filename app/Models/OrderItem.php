<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // Nama tabel di database
    protected $table = 'order_items';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'id_order', 
        'id_produk', 
        'id_profil_customer', 
        'stok', 
        'harga'
    ];

    // Relasi ke tabel Order
    public function order() 
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    // Relasi ke tabel Produk (sebelumnya menu)
    public function produk() 
    {
        // Parameter kedua adalah nama kolom foreign key di tabel order_items
        return $this->belongsTo(produk::class, 'id_produk');
    }

    // Relasi ke tabel Profil Customer
    public function customer() 
    {
        return $this->belongsTo(profilCustomer::class, 'user_id');
    }
    public function menu() 
    {
    return $this->belongsTo(Menu::class, 'id_produk'); 
    }
}
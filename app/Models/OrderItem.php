<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // Nama tabel di database
    protected $table = 'order_items';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'order_id', 
        'id_produk', 
        'id_profil_customer', 
        'quantity', 
        'price'
    ];

    // Relasi ke tabel Order
    public function order() 
    {
        return $this->belongsTo(Order::class, 'order_id');
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
        return $this->belongsTo(profilCustomer::class, 'id_profil_customer');
    }
}
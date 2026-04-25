<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $fillable = ['user_id', 'store_id', 'total_amount', 'status'];

    // Relasi ke tabel User (Pembeli)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Store (Toko Kantin)
    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}



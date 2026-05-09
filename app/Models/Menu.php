<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['id_seller', 'nama_produk', 'harga', 'is_active'];

    public function seller() {
        return $this->belongsTo(AkunSellerModel::class, 'id_seller'); 
    }
}
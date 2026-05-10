<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'produk_id',
        'rating',
        'ulasan',
    ];
    public function produk()
{
    return $this->belongsTo(produk::class, 'produk_id', 'id');
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $fillable = ['nama_kategori'];
    protected $table = 'kategoris';
    public function produk()
    {
        return $this->hasMany(produk::class, 'id_kategori');
    }
}

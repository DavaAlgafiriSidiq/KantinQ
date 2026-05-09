<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    protected $table = 'favorites';
    protected $fillable = ['id_user', 'id_produk', 'id_order'];

    public function produk()
    {
        return $this->belongsTo(produk::class, 'id_produk');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }
}

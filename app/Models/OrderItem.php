<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

  
    protected $fillable = [
        'order_id', 
        'id_produk', 
        'id_profil_customer', 
        'quantity', 
        'price'     
    ];

    public function order() 
    {
        return $this->belongsTo(Order::class, 'order_id'); 
    }

    public function produk() 
    {
        return $this->belongsTo(produk::class, 'id_produk');
    }

    public function customer() 
    {
        return $this->belongsTo(profilCustomer::class, 'user_id');
    }

    public function menu() 
    {
        return $this->belongsTo(Menu::class, 'id_produk'); 
    }
}
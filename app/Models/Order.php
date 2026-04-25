<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['store_id', 'total_amount', 'status'];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}


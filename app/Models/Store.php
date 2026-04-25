<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{ 
    protected $fillable = ['name', 'is_open'];

    public function menus() {
        return $this->hasMany(Menu::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}

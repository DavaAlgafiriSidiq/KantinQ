<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AkunSellerModel extends Authenticatable
{
    protected $table = 'seller';
    protected $fillable = ['username', 'email', 'password'];
}

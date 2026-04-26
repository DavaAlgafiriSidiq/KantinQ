<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AkunSellerModel extends Authenticatable
{
    use Notifiable;

    protected $table = 'seller';
    
    protected $fillable = [
        'username', 
        'email', 
        'password',
        'nama_toko',      
        'nomor_hp',       
        'deskripsi_toko', 
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\SellerFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AkunSellerModel extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected static function newFactory()
    {
        // Arahkan ke file factory yang benar
        return SellerFactory::new();
    }

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

    public function produks() // Relasi dengan model Produk satu toko punya banyak produk
    {
        return $this->hasMany(Produk::class, 'id_seller');
    }
}


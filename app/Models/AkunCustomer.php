<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AkunCustomer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'nomor_handphone', 
        'email',
        'password',
        'foto', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    
    public function profilCustomer()
    {
        return $this->hasOne(ProfilCustomer::class, 'user_id', 'id');
    }

    public function favorites()
    {
        return $this->belongsToMany(produk::class, 'favorites', 'id_user', 'id_produk');
    }
}
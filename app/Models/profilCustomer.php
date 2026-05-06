<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilCustomer extends Model 
{
    protected $table = 'profil_customers';
    
    protected $fillable = [
        'user_id', 
        'name', 
        'phone', 
        'foto' 
    ];

    public function akun() {
        return $this->belongsTo(AkunCustomer::class, 'user_id', 'id');
    }
}
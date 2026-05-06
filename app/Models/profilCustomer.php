<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilCustomer extends Model {
    protected $table = 'profil_customers';
    protected $primaryKey = 'id'; 
    public $incrementing = false;

    protected $fillable = [
        'id', 
        'name', 
        'phone', 
        'foto' 
    ];

    public function akun() {
        return $this->belongsTo(AkunCustomer::class, 'id', 'id');
    }
}
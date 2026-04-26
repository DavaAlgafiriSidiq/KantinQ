<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSeller extends Model
{
    protected $table = 'profil_sellers'; 

    protected $primaryKey = 'id';
    public $incrementing = false; 

    protected $fillable = ['id', 'nama_toko', 'deskripsi_toko', 'nomor_hp'];
}   
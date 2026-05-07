<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class keranjang extends Model
{
    protected $table = 'keranjang';

        protected $fillable = [
            'id_produk',
            'id_seller',
            'id_profil_customer',
            'jumlah',
            'catatan'
        ];

        public function produk()
        {
            return $this->belongsTo(produk::class, 'id_produk');
        }

        public function seller()
        {
            return $this->belongsTo(AkunSellerModel::class, 'id_seller');
        }

        public function profil()
        {
            // Keranjang ini milik profilCustomer tertentu
            return $this->belongsTo(profilCustomer::class, 'id_profil_customer');
        }
}

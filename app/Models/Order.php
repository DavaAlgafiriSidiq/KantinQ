<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'id_seller', 'id_profil_customer', 'kode_pesanan',
        'total_amount', 'metode_bayar', 'status',
        'status_midtrans', 'snap_token', 'kode_unik',
        'catatan', 'waktu_pengambilan',
    ];

    public function profilCustomer()
    {
        return $this->belongsTo(profilCustomer::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

        public function seller()
    {
        // Menggunakan id_seller sebagai foreign key
        return $this->belongsTo(AkunSellerModel::class, 'id_seller');
    }
}



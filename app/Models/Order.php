<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // PERBAIKAN: Sesuaikan dengan struktur database orders
    protected $fillable = [
        'user_id',
        'member_id',
        'subtotal',
        'total_diskon',
        'total_bayar',
        'metode_pembayaran',
        'tipe_pesanan',
        'status_pesanan',
        'shift_id',
    ];

    // PERBAIKAN: Accessor untuk kompatibilitas
    public function getTotalHargaAttribute()
    {
        return $this->total_bayar;
    }

    public function getStatusPembayaranAttribute()
    {
        // Default value atau sesuaikan dengan logika bisnis
        return 'menunggu';
    }

    public function getMetodePembayaranAttribute()
    {
        return $this->attributes['metode_pembayaran'] ?? 'transfer';
    }

    public function getNomorPesananAttribute()
    {
        return 'ORD' . $this->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}

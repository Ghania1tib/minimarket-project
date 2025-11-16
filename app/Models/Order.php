<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'member_id',
        'subtotal',
        'total_diskon',
        'total_bayar',
        'metode_pembayaran',
        'tipe_pesanan',
        'status_pesanan'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total_diskon' => 'decimal:2',
        'total_bayar' => 'decimal:2',
    ];

    // Relasi ke user (kasir)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Relasi ke order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accessor untuk format rupiah
    public function getSubtotalFormattedAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getTotalBayarFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_bayar, 0, ',', '.');
    }

    public function getTotalDiskonFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_diskon, 0, ',', '.');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // PERBAIKAN: Sesuaikan dengan struktur database order_items
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'harga_saat_beli',
        'diskon_item'
    ];

    // PERBAIKAN: Accessor untuk kompatibilitas
    public function getJumlahAttribute()
    {
        return $this->quantity;
    }

    public function getHargaSatuanAttribute()
    {
        return $this->harga_saat_beli;
    }

    public function getSubtotalAttribute()
    {
        return ($this->harga_saat_beli - ($this->diskon_item ?? 0)) * $this->quantity;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

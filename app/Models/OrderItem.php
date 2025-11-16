<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'harga_saat_beli',
        'diskon_item'
    ];

    protected $casts = [
        'harga_saat_beli' => 'decimal:2',
        'diskon_item' => 'decimal:2',
    ];

    // Relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Hitung subtotal per item
    public function getSubtotalAttribute()
    {
        return ($this->harga_saat_beli - $this->diskon_item) * $this->quantity;
    }

    // Accessor untuk format rupiah
    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_saat_beli, 0, ',', '.');
    }

    public function getDiskonFormattedAttribute()
    {
        return 'Rp ' . number_format($this->diskon_item, 0, ',', '.');
    }

    public function getSubtotalFormattedAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}

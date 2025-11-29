<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

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

    // Accessor untuk kompatibilitas
    public function getQtyAttribute()
    {
        return $this->quantity;
    }

    public function getHargaAttribute()
    {
        return $this->harga_saat_beli;
    }

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

    public function getNamaProdukAttribute()
    {
        return $this->product->nama_produk ?? 'Produk';
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

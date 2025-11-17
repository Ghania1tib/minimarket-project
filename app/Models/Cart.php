<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // PERBAIKAN: Sesuaikan dengan struktur database yang sebenarnya
    protected $table = 'carts';

    protected $fillable = [
        'user_id',      // Sesuai dengan database
        'product_id',   // Sesuai dengan database
        'quantity',     // Sesuai dengan database
    ];

    // PERBAIKAN: Hapus boot method karena tidak ada kolom subtotal di database
    // Gunakan accessor untuk menghitung subtotal

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // PERBAIKAN: Tambahkan accessor untuk kompatibilitas
    public function getPelangganIdAttribute()
    {
        return $this->user_id;
    }

    public function getProdukIdAttribute()
    {
        return $this->product_id;
    }

    public function getJumlahAttribute()
    {
        return $this->quantity;
    }

    public function setJumlahAttribute($value)
    {
        $this->attributes['quantity'] = $value;
    }

    public function getHargaSatuanAttribute()
    {
        return $this->product ? $this->product->harga_jual : 0;
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->harga_satuan;
    }
}

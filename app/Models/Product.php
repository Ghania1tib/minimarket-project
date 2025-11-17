<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'category_id',
        'barcode',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_kritis',
        'deskripsi',
        'gambar_url'
    ];

    protected $appends = ['is_stok_kritis'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Accessor untuk cek stok kritis
    public function getIsStokKritisAttribute()
    {
        return $this->stok <= $this->stok_kritis;
    }
}

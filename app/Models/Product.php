<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'nama_produk',
        'barcode',
        'deskripsi',
        'gambar_url',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_kritis'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Accessor untuk harga format Rupiah
    public function getHargaJualFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_jual, 0, ',', '.');
    }

    public function getHargaBeliFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_beli, 0, ',', '.');
    }

    // Accessor untuk mendapatkan URL gambar lengkap
    public function getFullGambarUrlAttribute()
    {
        return $this->gambar_url ? asset('storage/' . $this->gambar_url) : 'https://placehold.co/180x180/e5e7eb/78797b?text=No+Image';
    }

    // Cek apakah stok kritis
    public function getIsStokKritisAttribute()
    {
        return $this->stok <= $this->stok_kritis;
    }
}

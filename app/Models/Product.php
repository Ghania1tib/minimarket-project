<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga_beli',
        'harga_jual',
        'stok',
        'category_id',
        'gambar_url',
        'diskon'
        // HAPUS: 'is_featured' dari fillable
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Accessor untuk URL gambar lengkap
    public function getFullGambarUrlAttribute()
    {
        if ($this->gambar_url) {
            // Cek apakah sudah full URL atau relative path
            if (filter_var($this->gambar_url, FILTER_VALIDATE_URL)) {
                return $this->gambar_url;
            }
            return asset('storage/' . $this->gambar_url);
        }
        return 'https://via.placeholder.com/200x150?text=Produk+Tidak+Tersedia';
    }

    // Accessor untuk format harga jual
    public function getHargaJualFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_jual, 0, ',', '.');
    }

    // Accessor untuk harga setelah diskon
    public function getHargaSetelahDiskonAttribute()
    {
        if ($this->diskon > 0) {
            return $this->harga_jual - ($this->harga_jual * $this->diskon / 100);
        }
        return $this->harga_jual;
    }

    // HAPUS: Method untuk cek apakah produk featured karena kolom tidak ada
    // public function getIsFeaturedAttribute($value)
    // {
    //     return (bool) $value;
    // }
}

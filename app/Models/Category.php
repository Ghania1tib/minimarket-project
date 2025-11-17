<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'icon_url'
    ];

    // Relasi ke produk - PERBAIKAN: Gunakan category_id
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Accessor untuk URL icon lengkap
    public function getFullIconUrlAttribute()
    {
        if ($this->icon_url) {
            // Cek apakah sudah full URL atau relative path
            if (filter_var($this->icon_url, FILTER_VALIDATE_URL)) {
                return $this->icon_url;
            }
            return asset('storage/' . $this->icon_url);
        }
        return null;
    }

    // Method untuk mendapatkan jumlah produk
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }
}

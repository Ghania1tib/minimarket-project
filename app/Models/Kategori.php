<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Tentukan nama tabel secara eksplisit

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'status'
    ];

    // Relasi ke produk
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Scope untuk kategori aktif
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}

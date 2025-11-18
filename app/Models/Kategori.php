<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'nama_kategori',
        'icon_url',
    ];

    /**
     * TAMBAHKAN FUNGSI INI:
     * Relasi ke Model Product.
     * Ini adalah relasi "hasMany" (satu kategori memiliki banyak produk).
     */
    public function products()
    {
        // Pastikan Anda punya Model 'Product' (dengan 'c')
        return $this->hasMany('App\Models\Product', 'category_id');
    }
}
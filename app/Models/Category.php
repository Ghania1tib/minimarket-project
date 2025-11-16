<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'nama_kategori',
        'icon_url'
    ];

    // Relasi ke products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Accessor untuk count products
    public function getJumlahProdukAttribute()
    {
        return $this->products()->count();
    }
}

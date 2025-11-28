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
        // HAPUS: 'wholesale_rules'
    ];

    protected $appends = ['is_stok_kritis', 'full_gambar_url'];
    // HAPUS: 'wholesale_info' dari $appends

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
        'stok_kritis' => 'integer'
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'category_id');
    }

    // Accessor untuk cek stok kritis
    public function getIsStokKritisAttribute()
    {
        return $this->stok <= $this->stok_kritis;
    }

    // Accessor untuk URL gambar lengkap
    public function getFullGambarUrlAttribute()
    {
        if (!$this->gambar_url) {
            return $this->generatePlaceholderSvg($this->nama_produk);
        }

        if (filter_var($this->gambar_url, FILTER_VALIDATE_URL)) {
            return $this->gambar_url;
        }

        return asset('storage/' . $this->gambar_url);
    }

    // Method untuk generate placeholder SVG
    private function generatePlaceholderSvg($text)
    {
        $encodedText = urlencode($text);
        return "data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='150' viewBox='0 0 200 150'%3E%3Crect width='200' height='150' fill='%23f8f9fa'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Arial, sans-serif' font-size='14' fill='%236c757d'%3E" . $encodedText . "%3C/text%3E%3C/svg%3E";
    }

    // Scope untuk produk aktif (stok > 0)
    public function scopeAvailable($query)
    {
        return $query->where('stok', '>', 0);
    }

    // Scope untuk pencarian produk
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('nama_produk', 'like', '%'.$term.'%')
              ->orWhere('barcode', 'like', '%'.$term.'%')
              ->orWhere('deskripsi', 'like', '%'.$term.'%');
        });
    }

    // Scope untuk dengan kategori
    public function scopeWithKategori($query)
    {
        return $query->with('kategori');
    }
}

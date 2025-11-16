<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_promo',
        'nama_promo',
        'deskripsi',
        'jenis_promo',
        'nilai_promo',
        'tanggal_mulai',
        'tanggal_berakhir',
        'kuota',
        'digunakan',
        'status',
        'minimal_pembelian',
        'maksimal_diskon'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'status' => 'boolean'
    ];

    public function scopeAktif($query)
    {
        return $query->where('status', true)
                    ->where('tanggal_mulai', '<=', now())
                    ->where('tanggal_berakhir', '>=', now());
    }

    public function getIsAktifAttribute()
    {
        return $this->status &&
               now()->between($this->tanggal_mulai, $this->tanggal_berakhir) &&
               ($this->kuota === null || $this->digunakan < $this->kuota);
    }

    public function getFormattedNilaiAttribute()
    {
        if ($this->jenis_promo === 'diskon_persentase') {
            return $this->nilai_promo . '%';
        }
        return 'Rp ' . number_format($this->nilai_promo, 0, ',', '.');
    }
}

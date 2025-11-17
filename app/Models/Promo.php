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
        'tanggal_mulai' => 'datetime',
        'tanggal_berakhir' => 'datetime',
        'status' => 'boolean'
    ];

    protected $appends = ['is_aktif', 'formatted_nilai', 'status_text', 'persentase_terpakai', 'sisa_kuota'];

    public function scopeAktif($query)
    {
        return $query->where('status', true)
                    ->where('tanggal_mulai', '<=', now())
                    ->where('tanggal_berakhir', '>=', now());
    }

    public function getIsAktifAttribute()
    {
        return $this->status &&
               $this->tanggal_mulai <= now() &&
               $this->tanggal_berakhir >= now() &&
               ($this->kuota === null || ($this->digunakan ?? 0) < $this->kuota);
    }

    public function getFormattedNilaiAttribute()
    {
        if ($this->jenis_promo === 'diskon_persentase') {
            return $this->nilai_promo . '%';
        }
        return 'Rp ' . number_format($this->nilai_promo, 0, ',', '.');
    }

    public function getStatusTextAttribute()
    {
        return $this->status ? 'Aktif' : 'Nonaktif';
    }

    public function getPersentaseTerpakaiAttribute()
    {
        if (!$this->kuota || $this->kuota == 0) {
            return 0;
        }

        $terpakai = $this->digunakan ?? 0;
        return ($terpakai / $this->kuota) * 100;
    }

    public function getSisaKuotaAttribute()
    {
        if (!$this->kuota) {
            return 'Unlimited';
        }

        $terpakai = $this->digunakan ?? 0;
        return $this->kuota - $terpakai;
    }

    public function getProgressClassAttribute()
    {
        $percentage = $this->persentase_terpakai;

        if ($percentage > 80) {
            return 'bg-danger';
        } elseif ($percentage > 50) {
            return 'bg-warning';
        } else {
            return 'bg-success';
        }
    }
}

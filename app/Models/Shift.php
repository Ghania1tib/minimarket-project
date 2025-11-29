<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    // Tetap gunakan timestamps karena sudah ditambahkan di migration
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'nama_kasir',
        'modal_awal',
        'status',
        'waktu_mulai',
        'waktu_selesai',
        'total_tunai_sistem',
        'total_debit_sistem',
        'total_qris_sistem',
        'uang_fisik_di_kasir',
        'selisih',
        'catatan'
    ];

    protected $casts = [
        'modal_awal' => 'decimal:2',
        'total_penjualan_sistem' => 'decimal:2',
        'total_tunai_sistem' => 'decimal:2',
        'total_debit_sistem' => 'decimal:2',
        'total_qris_sistem' => 'decimal:2',
        'uang_fisik_di_kasir' => 'decimal:2',
        'selisih' => 'decimal:2',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessor untuk handle null values
    public function getTotalPenjualanSistemAttribute($value)
    {
        return $value ?? 0;
    }

    public function getTotalTunaiSistemAttribute($value)
    {
        return $value ?? 0;
    }

    public function getUangFisikDiKasirAttribute($value)
    {
        return $value ?? 0;
    }

    public function getSelisihAttribute($value)
    {
        return $value ?? 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isClosed()
    {
        return $this->status === 'closed';
    }

    public function getTotalPenjualanAttribute()
    {
        return ($this->total_tunai_sistem ?? 0) + ($this->total_debit_sistem ?? 0) + ($this->total_qris_sistem ?? 0);
    }

    public function getDurasiShiftAttribute()
    {
        if ($this->waktu_selesai) {
            return $this->waktu_mulai->diff($this->waktu_selesai);
        }
        return $this->waktu_mulai->diff(now());
    }

    // Method untuk handle nama kolom lama
    public function getTotalPerjualanSistemAttribute($value)
    {
        return $this->total_penjualan_sistem;
    }

    public function getTotalTunalSistemAttribute($value)
    {
        return $this->total_tunai_sistem;
    }

    public function getSelfishAttribute($value)
    {
        return $this->selisih;
    }

    public function getUangFisikDiLaciAttribute($value)
    {
        return $this->uang_fisik_di_kasir;
    }
}

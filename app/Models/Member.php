<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'kode_member',
        'user_id',
        'nama_lengkap',
        'nomor_telepon',
        'poin',
        'tanggal_daftar',
        'diskon' // TAMBAHKAN INI
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'poin' => 'integer',
        'diskon' => 'integer' // TAMBAHKAN INI
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Accessor untuk format poin
    public function getPoinFormattedAttribute()
    {
        return number_format($this->poin, 0, ',', '.');
    }

    // Method untuk generate kode member
    public static function generateKodeMember()
    {
        $prefix = 'MB';
        $date = date('Ymd');
        $lastMember = self::where('kode_member', 'like', $prefix . $date . '%')->latest()->first();

        if ($lastMember) {
            $lastNumber = intval(substr($lastMember->kode_member, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $date . $newNumber;
    }

    // TAMBAHKAN: Method untuk mendapatkan diskon member (default 10%)
    public function getDiskonAttribute($value)
    {
        return $value ?? 10; // Default 10% jika tidak diisi
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Method untuk mengecek role
    public function isOwner()
    {
        return $this->role === 'owner';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKasir()
    {
        return $this->role === 'kasir';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    // Accessor untuk nama role
    public function getRoleNameAttribute()
    {
        $roles = [
            'owner' => 'Pemilik',
            'admin' => 'Administrator',
            'kasir' => 'Kasir',
            'customer' => 'Pelanggan'
        ];

        return $roles[$this->role] ?? 'Unknown';
    }
    public function registeredViaGoogle()
    {
        return $this->registered_via === 'google' || !empty($this->google_id);
    }

    // Scope untuk mencari user by Google ID
    public function scopeByGoogleId($query, $googleId)
    {
        return $query->where('google_id', $googleId);
    }
}

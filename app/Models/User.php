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

    /**
     * Cek apakah user adalah owner
     */
    public function isOwner()
    {
        return $this->role === 'owner';
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin' || $this->role === 'owner';
    }

    /**
     * Cek apakah user adalah kasir
     */
    public function isKasir()
    {
        return $this->role === 'kasir';
    }

    /**
     * Cek apakah user adalah customer
     */
    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    /**
     * Relasi dengan orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relasi dengan cart
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relasi dengan shifts (jika user adalah kasir)
     */
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}

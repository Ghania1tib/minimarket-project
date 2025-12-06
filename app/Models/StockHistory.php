<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    protected $table = 'stock_history';
    
    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'jumlah_perubahan',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'tanggal_perubahan'
    ];

    protected $casts = [
        'tanggal_perubahan' => 'datetime',
        'jumlah_perubahan' => 'integer',
        'stok_sebelum' => 'integer',
        'stok_sesudah' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
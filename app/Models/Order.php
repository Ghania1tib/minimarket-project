<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Konstanta Status Pembayaran
    const STATUS_PEMBAYARAN_MENUNGGU = 'menunggu_pembayaran';
    const STATUS_PEMBAYARAN_VERIFIKASI = 'menunggu_verifikasi';
    const STATUS_PEMBAYARAN_TERVERIFIKASI = 'terverifikasi';
    const STATUS_PEMBAYARAN_DITOLAK = 'ditolak';

    // Konstanta Status Pesanan
    const STATUS_PESANAN_MENUNGGU = 'menunggu_pembayaran';
    const STATUS_PESANAN_VERIFIKASI = 'menunggu_verifikasi';
    const STATUS_PESANAN_DIPROSES = 'diproses';
    const STATUS_PESANAN_DIKIRIM = 'dikirim';
    const STATUS_PESANAN_SELESAI = 'selesai';
    const STATUS_PESANAN_DIBATALKAN = 'dibatalkan';

    protected $fillable = [
        'user_id',
        'member_id',
        'shift_id',
        'order_number',
        'subtotal',
        'total_diskon',
        'shipping_cost',
        'total_bayar',
        'metode_pembayaran',
        'nomor_rekening',
        'bukti_pembayaran',
        'status_pembayaran',
        'catatan_verifikasi',
        'tipe_pesanan',
        'status_pesanan',
        'nama_lengkap',
        'no_telepon',
        'alamat',
        'kota',
        'metode_pengiriman',
        'catatan',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total_diskon' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_bayar' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessor untuk kompatibilitas
    public function getTotalHargaAttribute()
    {
        return $this->total_bayar;
    }

    public function getTotalAmountAttribute()
    {
        return $this->total_bayar;
    }

    public function getStatusAttribute()
    {
        return $this->status_pesanan;
    }

    public function getNomorPesananAttribute()
    {
        return $this->order_number ?? 'ORD' . $this->id;
    }

    // Method untuk mendapatkan opsi status pembayaran
    public static function getStatusPembayaranOptions()
    {
        return [
            self::STATUS_PEMBAYARAN_MENUNGGU => 'Menunggu Pembayaran',
            self::STATUS_PEMBAYARAN_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_PEMBAYARAN_TERVERIFIKASI => 'Terverifikasi',
            self::STATUS_PEMBAYARAN_DITOLAK => 'Ditolak',
        ];
    }

    // Method untuk mendapatkan opsi status pesanan
    public static function getStatusPesananOptions()
    {
        return [
            self::STATUS_PESANAN_MENUNGGU => 'Menunggu Pembayaran',
            self::STATUS_PESANAN_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_PESANAN_DIPROSES => 'Diproses',
            self::STATUS_PESANAN_DIKIRIM => 'Dikirim',
            self::STATUS_PESANAN_SELESAI => 'Selesai',
            self::STATUS_PESANAN_DIBATALKAN => 'Dibatalkan',
        ];
    }

    // Method untuk cek apakah bisa diverifikasi
    public function canBeVerified()
    {
        return in_array($this->status_pembayaran, [
            self::STATUS_PEMBAYARAN_MENUNGGU,
            self::STATUS_PEMBAYARAN_VERIFIKASI
        ]);
    }

    // Method untuk cek apakah pembayaran sudah terverifikasi
    public function isPaymentVerified()
    {
        return $this->status_pembayaran === self::STATUS_PEMBAYARAN_TERVERIFIKASI;
    }

    // Method untuk cek apakah menunggu verifikasi
    public function isPendingVerification()
    {
        return $this->status_pembayaran === self::STATUS_PEMBAYARAN_VERIFIKASI;
    }

    // Method untuk verifikasi pembayaran
    public function verifyPayment($catatan = null)
    {
        $this->update([
            'status_pembayaran' => self::STATUS_PEMBAYARAN_TERVERIFIKASI,
            'status_pesanan' => self::STATUS_PESANAN_DIPROSES,
            'catatan_verifikasi' => $catatan
        ]);

        return $this;
    }

    // Method untuk tolak pembayaran
    public function rejectPayment($alasan)
    {
        $this->update([
            'status_pembayaran' => self::STATUS_PEMBAYARAN_DITOLAK,
            'status_pesanan' => self::STATUS_PESANAN_DIBATALKAN,
            'catatan_verifikasi' => $alasan
        ]);

        // Kembalikan stok produk
        $this->restoreStock();

        return $this;
    }

    // Method untuk mengembalikan stok
    public function restoreStock()
    {
        foreach ($this->orderItems as $item) {
            $item->product()->increment('stok', $item->quantity);
        }
    }

    // Method untuk timeline status
    public function getTimelineAttribute()
    {
        $timeline = [];

        // Status dasar - pesanan dibuat
        $timeline[] = [
            'status' => 'Pesanan Dibuat',
            'description' => 'Pesanan telah berhasil dibuat',
            'tanggal' => $this->created_at,
            'icon' => 'fas fa-shopping-cart',
            'active' => true
        ];

        // Status berdasarkan status pesanan dan pembayaran
        $statusConfig = [
            'menunggu_pembayaran' => [
                'status' => 'Menunggu Pembayaran',
                'description' => 'Menunggu pembayaran dari customer',
                'icon' => 'fas fa-clock'
            ],
            'menunggu_verifikasi' => [
                'status' => 'Menunggu Verifikasi',
                'description' => 'Menunggu verifikasi pembayaran oleh admin',
                'icon' => 'fas fa-hourglass-half'
            ],
            'diproses' => [
                'status' => 'Pesanan Diproses',
                'description' => 'Pesanan sedang diproses oleh penjual',
                'icon' => 'fas fa-cogs'
            ],
            'dikirim' => [
                'status' => 'Pesanan Dikirim',
                'description' => 'Pesanan sedang dalam pengiriman',
                'icon' => 'fas fa-shipping-fast'
            ],
            'selesai' => [
                'status' => 'Pesanan Selesai',
                'description' => 'Pesanan telah sampai dan selesai',
                'icon' => 'fas fa-check-circle'
            ],
            'dibatalkan' => [
                'status' => 'Pesanan Dibatalkan',
                'description' => 'Pesanan telah dibatalkan',
                'icon' => 'fas fa-times-circle'
            ]
        ];

        $currentStatus = $this->status_pembayaran == 'menunggu_verifikasi' ? 'menunggu_verifikasi' : $this->status_pesanan;
        $foundCurrent = false;

        foreach ($statusConfig as $status => $config) {
            $isActive = !$foundCurrent && ($status == $currentStatus);
            if ($status == $currentStatus) {
                $foundCurrent = true;
            }

            $timeline[] = [
                'status' => $config['status'],
                'description' => $config['description'],
                'tanggal' => $this->getStatusTime($status),
                'icon' => $config['icon'],
                'active' => $isActive
            ];
        }

        return $timeline;
    }

    private function getStatusTime($status)
    {
        // Logic untuk menentukan waktu status
        switch ($status) {
            case 'menunggu_pembayaran':
                return $this->created_at;
            case 'menunggu_verifikasi':
                return $this->bukti_pembayaran ? $this->updated_at : $this->created_at->addMinutes(10);
            case 'diproses':
                return $this->created_at->addMinutes(30);
            case 'dikirim':
                return $this->created_at->addHours(2);
            case 'selesai':
                return $this->created_at->addDays(1);
            case 'dibatalkan':
                return $this->updated_at;
            default:
                return $this->created_at;
        }
    }

    // Scope untuk pesanan yang butuh verifikasi
    public function scopePendingVerification($query)
    {
        return $query->where('status_pembayaran', self::STATUS_PEMBAYARAN_VERIFIKASI)
                    ->where('tipe_pesanan', 'website');
    }

    // Scope untuk pesanan online
    public function scopeOnlineOrders($query)
    {
        return $query->where('tipe_pesanan', 'website');
    }

    // Scope untuk pesanan POS
    public function scopePosOrders($query)
    {
        return $query->where('tipe_pesanan', 'pos');
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Method untuk mendapatkan label status pembayaran
    public function getPaymentStatusLabelAttribute()
    {
        $statuses = [
            self::STATUS_PEMBAYARAN_MENUNGGU => ['class' => 'warning', 'text' => 'Menunggu Pembayaran'],
            self::STATUS_PEMBAYARAN_VERIFIKASI => ['class' => 'info', 'text' => 'Menunggu Verifikasi'],
            self::STATUS_PEMBAYARAN_TERVERIFIKASI => ['class' => 'success', 'text' => 'Terverifikasi'],
            self::STATUS_PEMBAYARAN_DITOLAK => ['class' => 'danger', 'text' => 'Ditolak'],
        ];

        return $statuses[$this->status_pembayaran] ?? ['class' => 'secondary', 'text' => $this->status_pembayaran];
    }

    // Method untuk mendapatkan label status pesanan
    public function getOrderStatusLabelAttribute()
    {
        $statuses = [
            self::STATUS_PESANAN_MENUNGGU => ['class' => 'warning', 'text' => 'Menunggu Pembayaran'],
            self::STATUS_PESANAN_VERIFIKASI => ['class' => 'info', 'text' => 'Menunggu Verifikasi'],
            self::STATUS_PESANAN_DIPROSES => ['class' => 'primary', 'text' => 'Diproses'],
            self::STATUS_PESANAN_DIKIRIM => ['class' => 'info', 'text' => 'Dikirim'],
            self::STATUS_PESANAN_SELESAI => ['class' => 'success', 'text' => 'Selesai'],
            self::STATUS_PESANAN_DIBATALKAN => ['class' => 'danger', 'text' => 'Dibatalkan'],
        ];

        return $statuses[$this->status_pesanan] ?? ['class' => 'secondary', 'text' => $this->status_pesanan];
    }
}

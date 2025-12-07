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
    const STATUS_PEMBAYARAN_LUNAS = 'lunas'; // Ditambahkan untuk konsistensi

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
        'verified_by',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total_diskon' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_bayar' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
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
            self::STATUS_PEMBAYARAN_LUNAS => 'Lunas', // Ditambahkan
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

    // Method untuk mendapatkan urutan status timeline
    public static function getTimelineOrder()
    {
        return [
            self::STATUS_PESANAN_MENUNGGU => 1,
            self::STATUS_PESANAN_VERIFIKASI => 2,
            self::STATUS_PESANAN_DIPROSES => 3,
            self::STATUS_PESANAN_DIKIRIM => 4,
            self::STATUS_PESANAN_SELESAI => 5,
            self::STATUS_PESANAN_DIBATALKAN => 0,
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
        return in_array($this->status_pembayaran, [
            self::STATUS_PEMBAYARAN_TERVERIFIKASI,
            self::STATUS_PEMBAYARAN_LUNAS
        ]);
    }

    // Method untuk cek apakah menunggu verifikasi
    public function isPendingVerification()
    {
        return $this->status_pembayaran === self::STATUS_PEMBAYARAN_VERIFIKASI;
    }

    // Method untuk cek apakah status bisa diubah ke menunggu verifikasi
    public function canChangeToVerification()
    {
        return $this->status_pesanan === self::STATUS_PESANAN_MENUNGGU &&
               $this->status_pembayaran === self::STATUS_PEMBAYARAN_MENUNGGU;
    }

    // Method untuk verifikasi pembayaran
    public function verifyPayment($catatan = null, $verifiedBy = null)
    {
        $this->update([
            'status_pembayaran' => self::STATUS_PEMBAYARAN_TERVERIFIKASI,
            'status_pesanan' => self::STATUS_PESANAN_DIPROSES,
            'catatan_verifikasi' => $catatan,
            'verified_by' => $verifiedBy,
            'tanggal_verifikasi' => now(),
            'updated_at' => now()
        ]);

        return $this;
    }

    // Method untuk tolak pembayaran
    public function rejectPayment($alasan, $rejectedBy = null)
    {
        $this->update([
            'status_pembayaran' => self::STATUS_PEMBAYARAN_DITOLAK,
            'status_pesanan' => self::STATUS_PESANAN_DIBATALKAN,
            'catatan_verifikasi' => $alasan,
            'verified_by' => $rejectedBy,
            'tanggal_verifikasi' => now(),
            'updated_at' => now()
        ]);

        // Kembalikan stok produk
        $this->restoreStock();

        return $this;
    }

    // Method untuk mengubah status pesanan
    public function changeOrderStatus($status, $catatan = null)
    {
        $validStatuses = [
            self::STATUS_PESANAN_VERIFIKASI,
            self::STATUS_PESANAN_DIPROSES,
            self::STATUS_PESANAN_DIKIRIM,
            self::STATUS_PESANAN_SELESAI,
            self::STATUS_PESANAN_DIBATALKAN
        ];

        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException("Status tidak valid");
        }

        $updateData = [
            'status_pesanan' => $status,
            'updated_at' => now()
        ];

        // Jika mengubah ke status verifikasi, update juga status pembayaran
        if ($status === self::STATUS_PESANAN_VERIFIKASI) {
            $updateData['status_pembayaran'] = self::STATUS_PEMBAYARAN_VERIFIKASI;
        }

        // Jika mengubah ke status diproses dan sebelumnya verifikasi, verifikasi pembayaran
        if ($status === self::STATUS_PESANAN_DIPROSES &&
            $this->status_pesanan === self::STATUS_PESANAN_VERIFIKASI) {
            $updateData['status_pembayaran'] = self::STATUS_PEMBAYARAN_TERVERIFIKASI;
        }

        // Tambahkan catatan jika ada
        if ($catatan) {
            $updateData['catatan_verifikasi'] = $this->catatan_verifikasi
                ? $this->catatan_verifikasi . "\n" . $catatan
                : $catatan;
        }

        $this->update($updateData);

        return $this;
    }

    // Method untuk mengupload bukti pembayaran
    public function uploadPaymentProof($filePath, $bankInfo = [])
    {
        $updateData = [
            'bukti_pembayaran' => $filePath,
            'status_pembayaran' => self::STATUS_PEMBAYARAN_VERIFIKASI,
            'status_pesanan' => self::STATUS_PESANAN_VERIFIKASI, // INI YANG PENTING
            'updated_at' => now()
        ];

        // Tambahkan info bank jika ada
        if (!empty($bankInfo['nomor_rekening'])) {
            $updateData['nomor_rekening'] = $bankInfo['nomor_rekening'];
        }
        if (!empty($bankInfo['nama_bank'])) {
            $updateData['nama_bank'] = $bankInfo['nama_bank'];
        }

        $this->update($updateData);

        return $this;
    }

    // Method untuk mengembalikan stok
    public function restoreStock()
    {
        foreach ($this->orderItems as $item) {
            if ($item->product) {
                $item->product()->increment('stok', $item->quantity);
            }
        }
    }

    // Method untuk timeline status - DIPERBAIKI
    public function getTimelineAttribute()
    {
        $timeline = [];

        // Status dasar - pesanan dibuat
        $timeline[] = [
            'status' => 'Pesanan Dibuat',
            'description' => 'Pesanan telah berhasil dibuat',
            'tanggal' => $this->created_at->format('d M Y H:i'),
            'icon' => 'fas fa-shopping-cart',
            'active' => true,
            'is_current' => false
        ];

        // Urutan timeline yang benar
        $statusOrder = $this->getTimelineOrder();
        $statusConfig = [
            self::STATUS_PESANAN_MENUNGGU => [
                'status' => 'Menunggu Pembayaran',
                'description' => 'Menunggu pembayaran dari customer',
                'icon' => 'fas fa-clock'
            ],
            self::STATUS_PESANAN_VERIFIKASI => [
                'status' => 'Menunggu Verifikasi',
                'description' => 'Menunggu verifikasi pembayaran oleh admin',
                'icon' => 'fas fa-hourglass-half'
            ],
            self::STATUS_PESANAN_DIPROSES => [
                'status' => 'Pesanan Diproses',
                'description' => 'Pesanan sedang diproses oleh penjual',
                'icon' => 'fas fa-cogs'
            ],
            self::STATUS_PESANAN_DIKIRIM => [
                'status' => 'Pesanan Dikirim',
                'description' => 'Pesanan sedang dalam pengiriman',
                'icon' => 'fas fa-shipping-fast'
            ],
            self::STATUS_PESANAN_SELESAI => [
                'status' => 'Pesanan Selesai',
                'description' => 'Pesanan telah sampai dan selesai',
                'icon' => 'fas fa-check-circle'
            ],
            self::STATUS_PESANAN_DIBATALKAN => [
                'status' => 'Pesanan Dibatalkan',
                'description' => 'Pesanan telah dibatalkan',
                'icon' => 'fas fa-times-circle'
            ]
        ];

        // Tentukan status saat ini
        $currentStatus = $this->getCurrentTimelineStatus();
        $currentOrder = $statusOrder[$currentStatus] ?? 0;

        foreach ($statusConfig as $statusKey => $config) {
            $statusOrderNumber = $statusOrder[$statusKey] ?? 0;
            $isCurrent = ($statusKey === $currentStatus);
            $isActive = ($statusOrderNumber <= $currentOrder) || $isCurrent;

            $timeline[] = [
                'status' => $config['status'],
                'description' => $config['description'],
                'tanggal' => $this->getStatusTime($statusKey),
                'icon' => $config['icon'],
                'active' => $isActive,
                'is_current' => $isCurrent,
                'status_key' => $statusKey
            ];
        }

        return $timeline;
    }

    // Method untuk menentukan status timeline saat ini
    private function getCurrentTimelineStatus()
    {
        // Prioritas 1: Status pembayaran menunggu verifikasi
        if ($this->status_pembayaran === self::STATUS_PEMBAYARAN_VERIFIKASI) {
            return self::STATUS_PESANAN_VERIFIKASI;
        }

        // Prioritas 2: Status pesanan dibatalkan
        if ($this->status_pesanan === self::STATUS_PESANAN_DIBATALKAN) {
            return self::STATUS_PESANAN_DIBATALKAN;
        }

        // Prioritas 3: Gunakan status pesanan
        return $this->status_pesanan;
    }

    // Method untuk mendapatkan waktu status - DIPERBAIKI
    private function getStatusTime($status)
    {
        switch ($status) {
            case self::STATUS_PESANAN_MENUNGGU:
                return $this->created_at->format('d M Y H:i');

            case self::STATUS_PESANAN_VERIFIKASI:
                // Jika sudah upload bukti pembayaran, gunakan waktu update
                if ($this->bukti_pembayaran) {
                    return $this->updated_at->format('d M Y H:i');
                }
                // Jika status saat ini verifikasi, tampilkan waktu update
                if ($this->status_pesanan === self::STATUS_PESANAN_VERIFIKASI ||
                    $this->status_pembayaran === self::STATUS_PEMBAYARAN_VERIFIKASI) {
                    return $this->updated_at->format('d M Y H:i');
                }
                return '-';

            case self::STATUS_PESANAN_DIPROSES:
                if (in_array($this->status_pesanan, [
                    self::STATUS_PESANAN_DIPROSES,
                    self::STATUS_PESANAN_DIKIRIM,
                    self::STATUS_PESANAN_SELESAI
                ])) {
                    // Gunakan waktu verifikasi jika ada, jika tidak waktu update
                    return $this->tanggal_verifikasi
                        ? $this->tanggal_verifikasi->format('d M Y H:i')
                        : $this->updated_at->format('d M Y H:i');
                }
                return '-';

            case self::STATUS_PESANAN_DIKIRIM:
                if (in_array($this->status_pesanan, [
                    self::STATUS_PESANAN_DIKIRIM,
                    self::STATUS_PESANAN_SELESAI
                ])) {
                    return $this->updated_at->format('d M Y H:i');
                }
                return '-';

            case self::STATUS_PESANAN_SELESAI:
                if ($this->status_pesanan === self::STATUS_PESANAN_SELESAI) {
                    return $this->updated_at->format('d M Y H:i');
                }
                return '-';

            case self::STATUS_PESANAN_DIBATALKAN:
                if ($this->status_pesanan === self::STATUS_PESANAN_DIBATALKAN) {
                    return $this->updated_at->format('d M Y H:i');
                }
                return '-';

            default:
                return '-';
        }
    }

    // Method untuk mendapatkan progress timeline dalam persen
    public function getTimelineProgressAttribute()
    {
        $statusOrder = $this->getTimelineOrder();
        $currentStatus = $this->getCurrentTimelineStatus();

        $currentOrder = $statusOrder[$currentStatus] ?? 0;
        $maxOrder = max($statusOrder);

        if ($currentStatus === self::STATUS_PESANAN_DIBATALKAN) {
            return 100; // Dibatalkan = 100% (selesai)
        }

        if ($maxOrder === 0) {
            return 0;
        }

        return round(($currentOrder / $maxOrder) * 100);
    }

    // Method untuk cek apakah status sudah melewati status tertentu
    public function hasPassedStatus($status)
    {
        $statusOrder = $this->getTimelineOrder();
        $currentStatus = $this->getCurrentTimelineStatus();

        $currentOrder = $statusOrder[$currentStatus] ?? 0;
        $checkOrder = $statusOrder[$status] ?? 0;

        return $checkOrder < $currentOrder;
    }

    // Scope untuk pesanan yang butuh verifikasi
    public function scopePendingVerification($query)
    {
        return $query->where('status_pembayaran', self::STATUS_PEMBAYARAN_VERIFIKASI)
                    ->where('tipe_pesanan', 'website');
    }

    // Scope untuk pesanan yang menunggu pembayaran
    public function scopePendingPayment($query)
    {
        return $query->where('status_pembayaran', self::STATUS_PEMBAYARAN_MENUNGGU)
                    ->where('tipe_pesanan', 'website');
    }

    // Scope untuk pesanan yang sudah terverifikasi
    public function scopeVerified($query)
    {
        return $query->whereIn('status_pembayaran', [
            self::STATUS_PEMBAYARAN_TERVERIFIKASI,
            self::STATUS_PEMBAYARAN_LUNAS
        ]);
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

    // Scope untuk pesanan aktif (belum selesai atau dibatalkan)
    public function scopeActive($query)
    {
        return $query->whereNotIn('status_pesanan', [
            self::STATUS_PESANAN_SELESAI,
            self::STATUS_PESANAN_DIBATALKAN
        ]);
    }

    // Scope untuk pesanan berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pesanan', $status);
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

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Method untuk mendapatkan label status pembayaran
    public function getPaymentStatusLabelAttribute()
    {
        $statuses = [
            self::STATUS_PEMBAYARAN_MENUNGGU => ['class' => 'warning', 'text' => 'Menunggu Pembayaran', 'badge' => 'badge-warning'],
            self::STATUS_PEMBAYARAN_VERIFIKASI => ['class' => 'info', 'text' => 'Menunggu Verifikasi', 'badge' => 'badge-info'],
            self::STATUS_PEMBAYARAN_TERVERIFIKASI => ['class' => 'success', 'text' => 'Terverifikasi', 'badge' => 'badge-success'],
            self::STATUS_PEMBAYARAN_LUNAS => ['class' => 'success', 'text' => 'Lunas', 'badge' => 'badge-success'],
            self::STATUS_PEMBAYARAN_DITOLAK => ['class' => 'danger', 'text' => 'Ditolak', 'badge' => 'badge-danger'],
        ];

        return $statuses[$this->status_pembayaran] ?? ['class' => 'secondary', 'text' => $this->status_pembayaran, 'badge' => 'badge-secondary'];
    }

    // Method untuk mendapatkan label status pesanan
    public function getOrderStatusLabelAttribute()
    {
        $statuses = [
            self::STATUS_PESANAN_MENUNGGU => ['class' => 'warning', 'text' => 'Menunggu Pembayaran', 'badge' => 'badge-warning'],
            self::STATUS_PESANAN_VERIFIKASI => ['class' => 'info', 'text' => 'Menunggu Verifikasi', 'badge' => 'badge-info'],
            self::STATUS_PESANAN_DIPROSES => ['class' => 'primary', 'text' => 'Diproses', 'badge' => 'badge-primary'],
            self::STATUS_PESANAN_DIKIRIM => ['class' => 'info', 'text' => 'Dikirim', 'badge' => 'badge-info'],
            self::STATUS_PESANAN_SELESAI => ['class' => 'success', 'text' => 'Selesai', 'badge' => 'badge-success'],
            self::STATUS_PESANAN_DIBATALKAN => ['class' => 'danger', 'text' => 'Dibatalkan', 'badge' => 'badge-danger'],
        ];

        return $statuses[$this->status_pesanan] ?? ['class' => 'secondary', 'text' => $this->status_pesanan, 'badge' => 'badge-secondary'];
    }

    // Method untuk mendapatkan status berikutnya yang mungkin
    public function getNextPossibleStatuses()
    {
        $currentStatus = $this->status_pesanan;

        $nextStatuses = [
            self::STATUS_PESANAN_MENUNGGU => [
                self::STATUS_PESANAN_VERIFIKASI,
                self::STATUS_PESANAN_DIBATALKAN
            ],
            self::STATUS_PESANAN_VERIFIKASI => [
                self::STATUS_PESANAN_DIPROSES,
                self::STATUS_PESANAN_DIBATALKAN
            ],
            self::STATUS_PESANAN_DIPROSES => [
                self::STATUS_PESANAN_DIKIRIM,
                self::STATUS_PESANAN_DIBATALKAN
            ],
            self::STATUS_PESANAN_DIKIRIM => [
                self::STATUS_PESANAN_SELESAI
            ],
            self::STATUS_PESANAN_SELESAI => [],
            self::STATUS_PESANAN_DIBATALKAN => [],
        ];

        return $nextStatuses[$currentStatus] ?? [];
    }

    // Method untuk cek apakah bisa diupdate ke status tertentu
    public function canUpdateToStatus($status)
    {
        return in_array($status, $this->getNextPossibleStatuses());
    }

    // Method untuk mendapatkan status yang bisa diupdate oleh admin
    public function getAdminUpdatableStatuses()
    {
        $allStatuses = [
            self::STATUS_PESANAN_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_PESANAN_DIPROSES => 'Diproses',
            self::STATUS_PESANAN_DIKIRIM => 'Dikirim',
            self::STATUS_PESANAN_SELESAI => 'Selesai',
            self::STATUS_PESANAN_DIBATALKAN => 'Dibatalkan',
        ];

        // Filter hanya status yang valid dari status saat ini
        $possibleStatuses = $this->getNextPossibleStatuses();

        return array_filter($allStatuses, function($key) use ($possibleStatuses) {
            return in_array($key, $possibleStatuses);
        }, ARRAY_FILTER_USE_KEY);
    }
}

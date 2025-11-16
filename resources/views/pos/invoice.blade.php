<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }
        .invoice-container {
            max-width: 300px;
            margin: 0 auto;
            padding: 10px;
        }
        .text-center {
            text-align: center;
        }
        .border-bottom {
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="text-center border-bottom">
            <h4 style="margin: 0;">MINIMARKET</h4>
            <p style="margin: 0; font-size: 12px;">Supermarket 4</p>
            <p style="margin: 0; font-size: 12px;">Jl. Contoh No. 123</p>
            <p style="margin: 0; font-size: 12px;">Telp: (021) 123-4567</p>
        </div>

        <!-- Info Transaksi -->
        <div class="border-bottom" style="margin-top: 10px;">
            <div class="item-row">
                <span>Invoice:</span>
                <span>#{{ $order->id }}</span>
            </div>
            <div class="item-row">
                <span>Tanggal:</span>
                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="item-row">
                <span>Kasir:</span>
                <span>{{ $order->user->nama_lengkap }}</span>
            </div>
            @if($order->member)
            <div class="item-row">
                <span>Member:</span>
                <span>{{ $order->member->kode_member }}</span>
            </div>
            @endif
        </div>

        <!-- Items -->
        <div style="margin: 10px 0;">
            @foreach($order->orderItems as $item)
            <div class="item-row">
                <div style="flex: 2;">
                    {{ $item->product->nama_produk }}
                </div>
                <div style="flex: 1; text-align: right;">
                    {{ $item->quantity }} x
                </div>
                <div style="flex: 2; text-align: right;">
                    {{ number_format($item->harga_saat_beli, 0, ',', '.') }}
                </div>
            </div>
            <div class="item-row" style="font-size: 12px;">
                <div style="flex: 2;"></div>
                <div style="flex: 1; text-align: right;"></div>
                <div style="flex: 2; text-align: right;">
                    {{ number_format($item->subtotal, 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Total -->
        <div class="border-bottom">
            <div class="item-row">
                <span>Subtotal:</span>
                <span>{{ $order->subtotal_formatted }}</span>
            </div>
            @if($order->total_diskon > 0)
            <div class="item-row">
                <span>Diskon:</span>
                <span>-{{ $order->total_diskon_formatted }}</span>
            </div>
            @endif
            <div class="item-row" style="font-weight: bold;">
                <span>TOTAL:</span>
                <span>{{ $order->total_bayar_formatted }}</span>
            </div>
            <div class="item-row">
                <span>Bayar:</span>
                <span>{{ $order->total_bayar_formatted }}</span>
            </div>
            <div class="item-row">
                <span>Metode:</span>
                <span>
                    @if($order->metode_pembayaran == 'tunai') Tunai
                    @elseif($order->metode_pembayaran == 'debit_kredit') Debit/Kredit
                    @else QRIS/E-Wallet
                    @endif
                </span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center" style="margin-top: 15px;">
            <p style="margin: 5px 0; font-size: 12px;">Terima kasih atas kunjungan Anda</p>
            <p style="margin: 5px 0; font-size: 12px;">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
        </div>
    </div>

    <div class="text-center mt-3 no-print">
        <button onclick="window.print()" class="btn btn-primary me-2">
            <i class="fas fa-print"></i> Cetak
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <script>
        // Auto print ketika halaman invoice dibuka
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

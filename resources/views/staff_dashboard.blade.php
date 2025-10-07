<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staff - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Gaya dari tema sebelumnya */
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .dashboard-card {
            max-width: 700px;
            width: 90%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            border-left: 10px solid #ffb6c1; /* Warna tema staff */
            animation: fadeIn 1s ease-out;
        }
        .header-staff {
            background-color: #ffb6c1; /* Warna pink lembut */
            color: #004f7c; /* Warna teks biru gelap */
            padding: 20px;
            border-radius: 10px 0 0 0;
            text-align: center;
        }

        /* Styling Fitur Cepat */
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px; /* Ditingkatkan sedikit */
            border-radius: 8px;
            transition: transform 0.2s, background-color 0.3s;
            text-decoration: none;
            color: #333;
            border: 1px solid transparent;
        }
        .feature-item:hover {
            background-color: #ffe8ec;
            border: 1px solid #ffb6c1;
            transform: translateY(-2px); /* Efek visual saat hover */
        }
        .feature-item i {
            font-size: 1.6rem; /* Ikon diperbesar */
            color: #ff6347;
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }

        /* Styling Tombol Utama POS */
        .btn-pos {
            background-color: #004f7c;
            border-color: #004f7c;
            color: white;
            font-size: 1.1rem;
            padding: 10px 30px;
            font-weight: bold; /* Dipertebal */
            transition: background-color 0.3s;
        }
        .btn-pos:hover {
            background-color: #003366;
            border-color: #003366;
            color: white;
        }
        .btn-outline-danger {
            font-weight: bold;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <div class="card dashboard-card">
        <div class="header-staff p-4">
            <h1 class="mb-1"><i class="fas fa-cash-register me-2"></i> KASIR DASHBOARD</h1>
        </div>

        <div class="card-body p-5">
            <p class="lead text-center mb-5">Selamat bertugas,! Fokus utama Anda adalah melayani pelanggan.</p>

            <div class="row">

                <div class="col-md-6">
                    <a href="{{ route('pos.new') }}" class="feature-item">
                        <i class="fas fa-plus-square"></i>
                        <div>
                            <p class="fw-bold mb-0">Mulai Transaksi Baru</p>
                            <small class="text-muted">Langsung ke antarmuka POS.</small>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('member.management') }}" class="feature-item">
                        <i class="fas fa-user-tag"></i>
                        <div>
                            <p class="fw-bold mb-0">Kelola Kartu Member</p>
                            <small class="text-muted">Daftar member baru atau cek poin.</small>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('inventory.check') }}" class="feature-item">
                        <i class="fas fa-search-dollar"></i>
                        <div>
                            <p class="fw-bold mb-0">Cek Harga dan Stok Produk</p>
                            <small class="text-muted">Cari produk berdasarkan barcode.</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('diskon.management') }}" class="feature-item">
                        <i class="fas fa-tags"></i>
                        <div>
                            <p class="fw-bold mb-0">Kelola Diskon/Promo</p>
                            <small class="text-muted">Lihat dan terapkan promo harian.</small>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="/laporan/kasir" class="feature-item">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <div>
                            <p class="fw-bold mb-0">Laporan Kas Harian</p>
                            <small class="text-muted">Tutup/buka shift dan cek selisih.</small>
                        </div>
                    </a>
                </div>

            </div>

            <hr class="my-5">

            <div class="d-flex justify-content-between align-items-center">

                <a href="{{ route('pos.new') }}" class="btn btn-pos shadow-sm">
                    <i class="fas fa-play me-2"></i> Buka POS
                </a>

                {{-- Tombol Logout --}}
                <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-danger shadow-sm">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </div>

            <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

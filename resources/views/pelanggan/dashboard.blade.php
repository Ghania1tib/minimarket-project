<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #004f7c;
            --secondary-blue: #003366;
            --accent-pink: #ffb6c1;
            --light-pink: #ffdde1;
            --light-blue: #a1c4fd;
            --gradient-bg: linear-gradient(135deg, #ffdde1 0%, #a1c4fd 100%);
            --card-gradient: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f8fafc;
            --card-bg: #ffffff;
        }

        body {
            background: var(--gradient-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
        }

        .page-title {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--text-light);
            margin-bottom: 2rem;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid #e5e7eb;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border: none;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: var(--card-bg);
            border-bottom: 1px solid #e5e7eb;
            padding: 1.25rem 1.5rem;
            border-radius: 15px 15px 0 0 !important;
            flex-shrink: 0;
        }

        .card-title {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 0;
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            border-color: transparent;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 79, 124, 0.3);
            background: linear-gradient(135deg, var(--secondary-blue) 0%, var(--primary-blue) 100%);
            border-color: transparent;
        }

        .btn-outline-primary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 79, 124, 0.3);
        }

        .stats-card {
            border-top: 4px solid;
            position: relative;
            overflow: hidden;
            text-align: center;
            padding: 1.5rem;
            border-radius: 15px;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: currentColor;
            opacity: 0.3;
        }

        .stats-card.total-orders { border-top-color: var(--success-color); color: var(--success-color); }
        .stats-card.pending-orders { border-top-color: var(--warning-color); color: var(--warning-color); }
        .stats-card.cart-items { border-top-color: var(--info-color); color: var(--info-color); }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
        }

        .stats-label {
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .welcome-section .btn-light {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            transition: all 0.3s ease;
        }

        .welcome-section .btn-light:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .welcome-section .btn-outline-light {
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: white;
            transition: all 0.3s ease;
        }

        .welcome-section .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: #f8fafc;
            color: var(--text-dark);
            font-weight: 600;
            border-bottom: 2px solid #e5e7eb;
            padding: 1rem 0.75rem;
        }

        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-paid { background-color: #dbeafe; color: #1e40af; }
        .status-processing { background-color: #e0e7ff; color: #3730a3; }
        .status-shipped { background-color: #dcfce7; color: #166534; }
        .status-completed { background-color: #dcfce7; color: #166534; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }

        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--text-light);
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--accent-pink);
        }

        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .tip-item {
            display: flex;
            align-items: flex-start;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .tip-item:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .tip-icon {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .tip-content h6 {
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .tip-content p {
            margin-bottom: 0;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .equal-height-row {
            display: flex;
            flex-wrap: wrap;
        }

        .equal-height-col {
            display: flex;
            flex-direction: column;
        }

        .alert {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            flex: 1;
        }

        .profile-info .mb-3 {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .profile-info .mb-3:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Header Section -->
        <div class="welcome-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2">Selamat Datang, {{ $user->nama_lengkap ?? $user->name }}!</h1>
                    <p class="mb-0 opacity-75">Ini adalah halaman akun Anda. Di sini Anda dapat melihat aktivitas terbaru dan mengelola informasi akun Anda.</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('home') }}" class="btn btn-light me-2">
                        <i class="fas fa-home me-2"></i>Halaman Utama
                    </a>
                    <a href="{{ route('pelanggan.keranjang') }}" class="btn btn-outline-light">
                        <i class="fas fa-shopping-cart me-2"></i>Keranjang ({{ $cartCount }})
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stats-card total-orders">
                    <div class="stats-number">{{ $totalOrders }}</div>
                    <div class="stats-label">Total Pesanan</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card pending-orders">
                    <div class="stats-number">{{ $pendingOrders }}</div>
                    <div class="stats-label">Pesanan Menunggu</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card cart-items">
                    <div class="stats-number">{{ $cartCount }}</div>
                    <div class="stats-label">Item di Keranjang</div>
                </div>
            </div>
        </div>

        <!-- Main Content Row dengan Equal Height -->
        <div class="row equal-height-row">
            <!-- Profil Section -->
            <div class="col-md-4 equal-height-col mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>Profil Saya
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="profile-info">
                            <div class="mb-3">
                                <strong class="d-block mb-1">Nama:</strong>
                                <span class="text-muted">{{ $user->nama_lengkap ?? $user->name }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-block mb-1">Email:</strong>
                                <span class="text-muted">{{ $user->email }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-block mb-1">Telepon:</strong>
                                <span class="text-muted">{{ $user->no_telepon ?? $user->phone ?? 'Belum diatur' }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-block mb-1">Alamat:</strong>
                                <span class="text-muted">{{ $user->alamat ?? $user->address ?? 'Belum diatur' }}</span>
                            </div>
                        </div>
                        <div class="mt-auto pt-3">
                            <a href="{{ route('pelanggan.profil') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-edit me-2"></i>Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pesanan Section -->
            <div class="col-md-8 equal-height-col mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Riwayat Pesanan Terbaru
                        </h5>
                        <a href="{{ route('pelanggan.pesanan') }}" class="btn btn-outline-primary btn-sm">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>No. Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>
                                                    <strong>{{ $order->order_number }}</strong>
                                                </td>
                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                                <td>
                                                    <span class="status-badge status-{{ $order->status }}">
                                                        {{ $order->status_label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('pelanggan.pesanan.detail', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-receipt"></i>
                                <h4 class="mt-3 mb-2">Belum Ada Pesanan</h4>
                                <p class="mb-4">Mulai berbelanja dan buat pesanan pertama Anda</p>
                                <a href="{{ route('home') }}" class="btn btn-primary">
                                    <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lightbulb me-2"></i>Tips Belanja
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="tips-grid">
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Cari Produk</h6>
                                    <p>Gunakan fitur pencarian untuk menemukan produk yang Anda butuhkan</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-cart-plus"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Tambah Keranjang</h6>
                                    <p>Klik "Tambah Keranjang" pada produk yang ingin dibeli</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Checkout</h6>
                                    <p>Lakukan checkout dari keranjang belanja Anda</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Lacak Pesanan</h6>
                                    <p>Pantau status pesanan Anda di halaman riwayat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alert setelah 5 detik
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);

        // Animasi cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Set equal height untuk cards
            function setEqualHeight() {
                const equalHeightCols = document.querySelectorAll('.equal-height-col');
                let maxHeight = 0;

                // Reset heights
                equalHeightCols.forEach(col => {
                    col.style.height = 'auto';
                });

                // Find max height
                equalHeightCols.forEach(col => {
                    const height = col.offsetHeight;
                    if (height > maxHeight) {
                        maxHeight = height;
                    }
                });

                // Set equal height
                equalHeightCols.forEach(col => {
                    col.style.height = maxHeight + 'px';
                });
            }

            // Set equal height on load and resize
            setEqualHeight();
            window.addEventListener('resize', setEqualHeight);
        });
    </script>
</body>
</html>

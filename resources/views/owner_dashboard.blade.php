<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin/Owner - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #a1c4fd, #ffdde1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #004f7c;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-3px);
        }
        .quick-action-link {
            text-decoration: none;
            color: inherit;
        }
        .quick-action-link:hover .card {
            background-color: #f0f8ff;
            border-color: #004f7c;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('owner.dashboard') }}">
                <i class="fas fa-chart-line"></i> Dashboard Admin/Owner
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Halo, <strong>{{ Auth::user()->nama_lengkap }} ({{ Auth::user()->role }})</strong>
                </span>
                <a class="btn btn-outline-light btn-sm me-2" href="{{ route('home') }}">
                    <i class="fas fa-home"></i> Landing Page
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <h1 class="mb-4 text-primary"><i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin/Owner</h1>
        <hr>

        <!-- QUICK ACTIONS / DATA MASTER -->
        <h3 class="mt-5 mb-3 text-secondary"><i class="fas fa-database me-2"></i> Manajemen Data Master</h3>
        <div class="row g-4">
            <div class="col-md-3">
                <a href="{{ route('produk.index') }}" class="quick-action-link">
                    <div class="card text-center p-3 border-primary">
                        <i class="fas fa-boxes fa-3x text-primary mb-2"></i>
                        <h5 class="card-title">Produk (CRUD)</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('kategori.index') }}" class="quick-action-link">
                    <div class="card text-center p-3 border-info">
                        <i class="fas fa-tags fa-3x text-info mb-2"></i>
                        <h5 class="card-title">Kategori (CRUD)</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('user.index') }}" class="quick-action-link">
                    <div class="card text-center p-3 border-success">
                        <i class="fas fa-users-cog fa-3x text-success mb-2"></i>
                        <h5 class="card-title">Akun Pengguna (CRUD)</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('diskon.management') }}" class="quick-action-link">
                    <div class="card text-center p-3 border-warning">
                        <i class="fas fa-percent fa-3x text-warning mb-2"></i>
                        <h5 class="card-title">Promo (CRUD)</h5>
                    </div>
                </a>
            </div>
        </div>

        <!-- REPORTS -->
        <h3 class="mt-5 mb-3 text-secondary"><i class="fas fa-chart-pie me-2"></i> Laporan & Analisis</h3>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center p-3 border-danger">
                    <i class="fas fa-file-invoice-dollar fa-3x text-danger mb-2"></i>
                    <h5 class="card-title">Laporan Penjualan (R)</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3 border-secondary">
                    <i class="fas fa-history fa-3x text-secondary mb-2"></i>
                    <h5 class="card-title">Riwayat Stok (R)</h5>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

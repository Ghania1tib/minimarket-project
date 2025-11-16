<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .navbar {
            background-color: #004f7c;
        }
        .main-content {
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-store"></i> Minimarket
            </a>

            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Halo, {{ Auth::user()->nama_lengkap }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container main-content">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Menu Pelanggan</h6>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('pelanggan.dashboard') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('pelanggan.profil') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user me-2"></i>Profil Saya
                        </a>
                        <a href="{{ route('pelanggan.riwayat') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-history me-2"></i>Riwayat Transaksi
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

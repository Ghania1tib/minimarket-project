<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Akun Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('layouts.partials.header')

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <h4>Menu Akun</h4>
                <div class="list-group">
                    <a href="{{ route('pelanggan.dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="{{ route('pelanggan.profil') }}" class="list-group-item list-group-item-action">Edit Profil</a>
                    <a href="{{ route('pelanggan.riwayat') }}" class="list-group-item list-group-item-action">Riwayat Transaksi</a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>

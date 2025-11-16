<header class="p-3 mb-3 border-bottom" style="background-color: #FFEFF3;">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                {{-- Ganti dengan logo Anda --}}
                <h4 class="fw-bold" style="color: #E84F88;">Supermarket 4</h4>
            </a>

            <div class="mx-auto col-12 col-lg-6 mb-3 mb-lg-0">
                {{-- FORM PENCARIAN --}}
                <form action="{{ route('produk.search') }}" method="GET" role="search">
                    <input type="search" name="keyword" class="form-control" placeholder="Cari produk (mis. Minyak Goreng, Bawang)" value="{{ request('keyword') }}">
                </form>
            </div>

            <div class="d-flex align-items-center">
                {{-- MENU TASKBAR --}}
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 link-secondary">📍 Lokasi</a></li>
                    <li><a href="{{ route('kategori.index') }}" class="nav-link px-2 link-dark">🏷️ Kategori</a></li>

                    {{-- Logic untuk Akun (Login/Dashboard) --}}
                    @auth
                        {{-- Jika sudah login, arahkan ke dashboard pelanggan --}}
                        <li><a href="{{ route('pelanggan.dashboard') }}" class="nav-link px-2 link-dark">👤 Akun</a></li>
                    @else
                        {{-- Jika belum login, arahkan ke halaman login --}}
                        <li><a href="{{ route('login') }}" class="nav-link px-2 link-dark">👤 Akun</a></li>
                    @endauth

                    <li>
                        <a href="#" class="nav-link px-2 link-dark">
                            🛒 Keranjang (0) {{-- Angka 0 bisa dibuat dinamis --}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

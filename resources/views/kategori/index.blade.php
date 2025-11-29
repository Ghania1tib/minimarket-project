@extends('layouts.admin-base')

@section('title', 'Manajemen Kategori')

@section('content')
    <div class="content-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-theme-primary" style="font-size: 1.75rem;"><i class="fas fa-tags me-2"></i> Manajemen Kategori</h1>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary-custom btn-md">
                <i class="fas fa-plus me-2"></i>Tambah Kategori
            </a>
        </div>
        <hr class="mt-0 mb-4">

        <div class="row g-3">
            @if(isset($kategories) && $kategories->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-tags fa-4x text-secondary mb-3"></i>
                    <h4>Belum ada kategori</h4>
                    <p class="text-muted">Mulai dengan menambahkan kategori pertama Anda.</p>
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary-custom mt-2">
                        <i class="fas fa-plus me-2"></i>Tambah Kategori Pertama
                    </a>
                </div>
            @else
                @foreach($kategories as $kategori)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card h-100 p-3 text-center bg-theme-light shadow-sm" style="border-top: 4px solid var(--color-accent);">
                            <div class="card-body p-3">
                                <div class="mb-3">
                                    {{-- Icon/Image Display --}}
                                    @if ($kategori->icon_url && filter_var($kategori->icon_url, FILTER_VALIDATE_URL))
                                        <img src="{{ $kategori->icon_url }}" alt="{{ $kategori->nama_kategori }}" class="rounded-3" style="width: 50px; height: 50px; object-fit: contain; border: 1px solid var(--color-primary);">
                                    @elseif(isset($kategori->icon_url))
                                        <img src="{{ asset('storage/' . $kategori->icon_url) }}" alt="{{ $kategori->nama_kategori }}" class="rounded-3" style="width: 50px; height: 50px; object-fit: contain; border: 1px solid var(--color-primary);">
                                    @else
                                        <i class="fas fa-layer-group fa-2x text-theme-primary"></i>
                                    @endif
                                </div>
                                <h6 class="card-title text-theme-primary fw-bold">{{ $kategori->nama_kategori }}</h6>
                                <p class="card-text text-muted small">
                                    {{ $kategori->products_count ?? 0 }} produk
                                </p>

                                <div class="btn-group w-100 mt-3">
                                    <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-primary-custom btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus kategori {{ $kategori->nama_kategori }}?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <style>
        /* Semua style CSS dari file asli ditempatkan di sini */
        :root {
            --color-primary: #5E548E;
            --color-secondary: #9F86C0;
            --color-accent: #E0B1CB;
            --color-danger: #E07A5F;
            --color-success: #70C1B3;
            --color-light: #F0E6EF;
            --color-white: #ffffff;
            --gradient-bg: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --border-radius-lg: 15px;
            --border-radius-sm: 8px;
        }

        .content-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 25px 15px;
            background-color: var(--color-white);
            border-radius: var(--border-radius-lg);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-primary-custom {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            font-weight: 600;
            border-radius: var(--border-radius-sm);
        }

        .btn-primary-custom:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
        }

        .text-theme-primary {
            color: var(--color-primary) !important;
        }

        .bg-theme-light {
            background-color: var(--color-light) !important;
        }

        .bg-theme-accent {
            background-color: var(--color-accent) !important;
        }
    </style>
@endsection

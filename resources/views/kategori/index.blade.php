<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-tags"></i> Daftar Kategori Produk</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Kategori
    </a>

    <div class="row">
        @foreach($kategori as $item)
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <img src="{{ $item->gambar }}" class="card-img-top" alt="{{ $item->nama }}">
            <div class="card-body">
                <h5 class="card-title">{{ $item->nama }}</h5>
                <a href="{{ route('kategori.show', $item->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Lihat</a>
                <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endforeach

    </div>
</div>

</body>
</html>

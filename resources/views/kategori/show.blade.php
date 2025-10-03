<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2><i class="bi bi-eye"></i> Detail Kategori</h2>
    <div class="card shadow-sm" style="width: 18rem;">
        <img src="{{ $kategori['gambar'] }}" class="card-img-top" alt="{{ $kategori['nama'] }}">
        <div class="card-body">
            <h5 class="card-title">{{ $kategori['nama'] }}</h5>
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

</body>
</html>

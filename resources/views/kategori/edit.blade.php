<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2><i class="bi bi-pencil"></i> Edit Kategori</h2>

    <form action="{{ route('kategori.update', $kategori['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $kategori['nama'] }}" required>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Link Gambar</label>
            <input type="url" class="form-control" id="gambar" name="gambar" value="{{ $kategori['gambar'] }}" required>
        </div>
        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Update</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>

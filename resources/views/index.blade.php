<!DOCTYPE html>
<html lang="en">
    
    

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermarket 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5 text-center">
        <h1 class="mb-4">Selamat Datang di Supermarket 4</h1>
        <p class="lead">Silakan pilih menu berikut:</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('kategori.index') }}" class="btn btn-primary">Kategori</a>
            <a href="{{ route('produk.index') }}" class="btn btn-success">Produk</a>
            <a href="{{ route('user.index') }}" class="btn btn-warning">User</a>
        </div>
    </div>
</body>
</html>

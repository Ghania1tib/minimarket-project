```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee); /* pink pastel + ocean blue */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar {
      background-color: #ff85a2;
    }
    .navbar-brand, .nav-link {
      color: #fff !important;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      transition: transform 0.2s;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card-title {
      font-size: 1.2rem;
      font-weight: bold;
      color: #333;
    }
    .card-text {
      color: #555;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Supermarket Project</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('kategori.index') }}"><i class="fas fa-list"></i> Kategori</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ route('produk.index') }}"><i class="fas fa-box"></i> Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('user.index') }}"><i class="fas fa-user"></i> User</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Daftar Produk -->
  <div class="container py-5">
    <h2 class="text-center mb-4">Daftar Produk</h2>
    <div class="row g-4">
      @foreach($produks as $produk)
      <div class="col-md-4">
        <div class="card p-3">
          <img src="https://via.placeholder.com/300x200" class="card-img-top rounded" alt="gambar produk">
          <div class="card-body">
            <h5 class="card-title">{{ $produk->nama }}</h5>
            <p class="card-text">Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
            <p class="card-text"><small class="text-muted">Kategori: {{ $produk->kategori->nama }}</small></p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

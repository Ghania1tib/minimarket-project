<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>minimarket - Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Gaya dasar dari CSS yang Anda sediakan */
        body {
            /* Latar belakang gradien */
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Styling Form Card */
        .login-card {
            max-width: 400px; /* Lebih ramping dari signup */
            width: 100%;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border-bottom: 5px solid #004f7c; /* Garis warna di bawah */
            animation: fadeIn 1s ease-out;
        }

        /* Judul */
        .login-card h5 {
            color: #004f7c;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }

        /* Styling Input Field */
        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #ffb6c1;
            box-shadow: 0 0 0 0.25rem rgba(255, 182, 193, 0.5);
        }

        /* Styling Button */
        .btn-primary {
            background-color: #ffb6c1; /* Warna pink lembut */
            border-color: #ffb6c1;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            transition: background-color 0.3s;
            color: #004f7c; /* Warna teks biru gelap */
        }

        .btn-primary:hover {
            background-color: #ff91a4; /* Warna lebih gelap saat hover */
            border-color: #ff91a4;
            color: #fff; /* Teks putih saat hover */
        }

        /* Styling Error Alert */
        .alert-danger {
            border-radius: 10px;
            font-size: 0.9rem;
        }

        /* Animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h5 class="text-uppercase">Masuk Ke Akun Anda</h5>
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('submit.login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Alamat Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" required placeholder="Masukkan email Anda"
                       value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Kata Sandi</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" required placeholder="Masukkan kata sandi">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt me-2"></i>Masuk</button>
            </div>
        </form>

        <p class="text-center mt-3 mb-0" style="font-size: 0.9rem;">
            Belum punya akun? <a href="{{ route('signup') }}" style="color: #004f7c; text-decoration: none; font-weight: 600;">Daftar di sini</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

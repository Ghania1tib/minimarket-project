<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>minimarket - Daftar Akun</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Gaya dasar (background gradient dan pemusatan) */
        body {
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
        .signup-card {
            max-width: 450px;
            width: 100%;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border-top: 5px solid #ffb6c1; /* Garis warna manis di atas */
            animation: fadeIn 1s ease-out;
        }

        /* Judul */
        .signup-card h5 {
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
            background-color: #004f7c; /* Biru gelap */
            border-color: #004f7c;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #003366;
            border-color: #003366;
        }

        /* Styling Error Alert */
        .alert-danger {
            border-radius: 10px;
            font-size: 0.9rem;
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        /* Animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="signup-card">
        <h5 class="text-uppercase">Daftar Akun Baru</h5>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('submit.signup') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label"><i class="fas fa-user me-2"></i>Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" required placeholder="Masukkan nama Anda" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Alamat Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" required placeholder="contoh@domain.com" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Kata Sandi</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" required placeholder="Minimal 8 karakter">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-2"></i>Daftar Sekarang</button>
            </div>
        </form>

        <p class="text-center mt-3 mb-0" style="font-size: 0.9rem;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color: #ffb6c1; text-decoration: none; font-weight: 600;">Masuk di sini</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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
            padding: 15px;
        }

        /* Styling Form Card */
        .signup-card {
            max-width: 420px;
            width: 100%;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            border-top: 4px solid #ffb6c1;
            animation: fadeIn 0.8s ease-out;
        }

        /* Judul */
        .signup-card h5 {
            color: #004f7c;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.4rem;
        }

        /* Styling Input Field */
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 8px 12px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #ffb6c1;
            box-shadow: 0 0 0 0.2rem rgba(255, 182, 193, 0.25);
        }

        /* Styling Label */
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 6px;
            color: #004f7c;
        }

        /* Styling Button */
        .btn-primary {
            background-color: #004f7c;
            border-color: #004f7c;
            border-radius: 8px;
            padding: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #003366;
            border-color: #003366;
            transform: translateY(-1px);
        }

        /* Styling Error Alert */
        .alert-danger {
            border-radius: 8px;
            font-size: 0.85rem;
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        /* Help text untuk password */
        .form-text {
            font-size: 0.8rem;
            margin-top: 4px;
        }

        /* Link untuk login */
        .login-link {
            font-size: 0.85rem;
            margin-top: 15px;
        }

        /* Animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Icon dalam input */
        .input-icon {
            color: #ffb6c1;
            width: 16px;
        }
    </style>
</head>
<body>
    <div class="signup-card">
        <h5 class="text-uppercase">Daftar Akun Baru</h5>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0 ps-3" style="font-size: 0.85rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('signup') }}" method="POST">
            @csrf

            <div class="mb-2">
                <label for="nama_lengkap" class="form-label">
                    <i class="fas fa-user me-1 input-icon"></i>Nama Lengkap
                </label>
                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                       id="nama_lengkap" name="nama_lengkap" required
                       placeholder="Masukkan nama lengkap" value="{{ old('nama_lengkap') }}">
                @error('nama_lengkap')
                    <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-1 input-icon"></i>Alamat Email
                </label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" required
                       placeholder="contoh@domain.com" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-1 input-icon"></i>Kata Sandi
                </label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" required
                       placeholder="Minimal 8 karakter">
                <small class="form-text text-muted">
                    Harus mengandung huruf besar, huruf kecil, dan angka
                </small>
                @error('password')
                    <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="no_telepon" class="form-label">
                        <i class="fas fa-phone me-1 input-icon"></i>Nomor Telepon
                    </label>
                    <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                           id="no_telepon" name="no_telepon" required
                           placeholder="No. telepon" value="{{ old('no_telepon') }}">
                    @error('no_telepon')
                        <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-2">
                    <label for="alamat" class="form-label">
                        <i class="fas fa-home me-1 input-icon"></i>Alamat
                    </label>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                           id="alamat" name="alamat" required
                           placeholder="Alamat lengkap" value="{{ old('alamat') }}">
                    @error('alamat')
                        <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>
            </div>
        </form>

        <p class="text-center login-link mb-0">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color: #ff6b8b; text-decoration: none; font-weight: 600;">
                Masuk di sini
            </a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

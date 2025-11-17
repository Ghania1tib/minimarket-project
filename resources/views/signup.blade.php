<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Saudara 2 - Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --color-primary: #5E548E; /* Dark Lilac */
            --color-secondary: #9F86C0; /* Medium Lilac */
            --color-accent: #E0B1CB; /* Nude Pink */
            --color-danger: #E07A5F; /* Soft Coral */
            --color-light: #F0E6EF; /* Very Light Lilac */
            --gradient-bg: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
        }
        body {
            background: var(--gradient-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 15px;
        }
        .signup-card {
            max-width: 420px;
            width: 100%;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-top: 5px solid var(--color-primary);
            animation: fadeIn 0.8s ease-out;
        }
        .signup-card h5 {
            color: var(--color-primary);
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.5rem;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 6px;
            color: var(--color-primary);
        }
        .form-control:focus {
            border-color: var(--color-accent);
            box-shadow: 0 0 0 0.2rem rgba(160, 134, 192, 0.25);
        }
        .input-icon {
            color: var(--color-accent);
            width: 16px;
        }
        .btn-theme-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            border-radius: 8px;
            padding: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        .btn-theme-primary:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            transform: translateY(-1px);
        }
        .login-link a {
            color: var(--color-danger) !important;
            text-decoration: none;
            font-weight: 600;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="signup-card">
        <h5 class="text-uppercase">Daftar Akun Baru</h5>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert" style="border-radius: 8px; font-size: 0.85rem;">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Route dikoreksi ke submit.signup sesuai convention Laravel --}}
        <form action="{{ route('submit.signup') }}" method="POST">
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
                <button type="submit" class="btn btn-theme-primary">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>
            </div>
        </form>

        <p class="text-center login-link mb-0 mt-3" style="font-size: 0.85rem;">
            Sudah punya akun?
            <a href="{{ route('login') }}">
                Masuk di sini
            </a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

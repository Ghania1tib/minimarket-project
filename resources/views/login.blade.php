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
        .login-card {
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
        .login-card h5 {
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

        /* Link untuk signup */
        .signup-link {
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

        /* Checkbox remember me */
        .form-check-input:checked {
            background-color: #004f7c;
            border-color: #004f7c;
        }

        .form-check-label {
            font-size: 0.85rem;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h5 class="text-uppercase">Masuk Ke Akun Anda</h5>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0 ps-3" style="font-size: 0.85rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert" style="border-radius: 8px; font-size: 0.85rem;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('submit.login') }}" method="POST">
            @csrf

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
                       placeholder="Masukkan kata sandi">
                @error('password')
                    <div class="invalid-feedback" style="font-size: 0.8rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>
            </div>
        </form>

        <p class="text-center signup-link mb-0">
            Belum punya akun?
            <a href="{{ route('signup') }}" style="color: #ff6b8b; text-decoration: none; font-weight: 600;">
                Daftar di sini
            </a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

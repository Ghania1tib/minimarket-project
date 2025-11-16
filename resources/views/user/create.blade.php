<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Baru - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #004f7c;
            --secondary-blue: #003366;
            --accent-pink: #ffb6c1;
            --light-pink: #ffdde1;
            --light-blue: #a1c4fd;
            --gradient-bg: linear-gradient(135deg, #ffdde1 0%, #a1c4fd 100%);
            --card-gradient: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        body {
            background: var(--gradient-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: none;
            background: var(--card-gradient);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 79, 124, 0.3);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-pink);
            box-shadow: 0 0 0 0.2rem rgba(255, 182, 193, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 8px;
        }

        .section-title {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 1rem;
            border-left: 4px solid var(--accent-pink);
            padding-left: 15px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .password-toggle {
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-blue);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('owner.dashboard') }}">
                <i class="fas fa-users-cog me-2"></i>Manajemen User
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link me-3" href="{{ route('owner.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                </a>
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i>{{ Auth::user()->nama_lengkap }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm logout-btn">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h2 class="section-title mb-0">
                                    <i class="fas fa-user-plus me-2"></i>Tambah User Baru
                                </h2>
                                <p class="text-muted mb-0">Isi form berikut untuk menambah user baru</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('user.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar User
                                </a>
                            </div>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama_lengkap" class="form-label">
                                        <i class="fas fa-user me-2"></i>Nama Lengkap
                                    </label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                           id="nama_lengkap" name="nama_lengkap"
                                           value="{{ old('nama_lengkap') }}"
                                           placeholder="Masukkan nama lengkap" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>Alamat Email
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email"
                                           value="{{ old('email') }}"
                                           placeholder="contoh@domain.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password"
                                               placeholder="Minimal 8 karakter" required>
                                        <span class="input-group-text password-toggle" onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Konfirmasi Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation" name="password_confirmation"
                                               placeholder="Ulangi password" required>
                                        <span class="input-group-text password-toggle" onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label">
                                        <i class="fas fa-user-tag me-2"></i>Role
                                    </label>
                                    <select class="form-control @error('role') is-invalid @enderror"
                                            id="role" name="role" required>
                                        <option value="">Pilih Role</option>
                                        <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon" class="form-label">
                                        <i class="fas fa-phone me-2"></i>Nomor Telepon
                                    </label>
                                    <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                                           id="no_telepon" name="no_telepon"
                                           value="{{ old('no_telepon') }}"
                                           placeholder="Contoh: 081234567890">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">
                                    <i class="fas fa-home me-2"></i>Alamat
                                </label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror"
                                          id="alamat" name="alamat" rows="3"
                                          placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="reset" class="btn btn-outline-secondary me-md-2">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.parentElement.querySelector('.password-toggle i');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Auto format phone number
        document.getElementById('no_telepon').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = value.substring(1);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>

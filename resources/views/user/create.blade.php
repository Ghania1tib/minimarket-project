@extends('layouts.admin-base')

@section('title', 'Tambah User Baru')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Form Tambah User -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
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
                                <input type="text" class="form-control search-box @error('nama_lengkap') is-invalid @enderror"
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
                                <input type="email" class="form-control search-box @error('email') is-invalid @enderror"
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
                                    <input type="password" class="form-control search-box @error('password') is-invalid @enderror"
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
                                    <input type="password" class="form-control search-box @error('password_confirmation') is-invalid @enderror"
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
                                <select class="form-control search-box @error('role') is-invalid @enderror"
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
                                <input type="text" class="form-control search-box @error('no_telepon') is-invalid @enderror"
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
                            <textarea class="form-control search-box @error('alamat') is-invalid @enderror"
                                      id="alamat" name="alamat" rows="3"
                                      placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="reset" class="btn btn-secondary">
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

<style>
/* Variabel CSS konsisten dengan halaman member */
:root {
    --color-primary: #5E548E;
    --color-secondary: #9F86C0;
    --color-accent: #E0B1CB;
    --color-danger: #E07A5F;
    --color-success: #70C1B3;
    --color-warning: #FFB347;
    --color-info: #5BC0DE;
    --color-light: #F0E6EF;
    --color-white: #ffffff;
    --border-radius-lg: 15px;
    --border-radius-sm: 8px;
}

/* Password Toggle */
.password-toggle {
    cursor: pointer;
    transition: color 0.3s ease;
    background-color: var(--color-light);
    border: 2px solid var(--color-accent);
    border-left: none;
    color: var(--color-primary);
}

.password-toggle:hover {
    color: var(--color-secondary);
    background-color: rgba(94, 84, 142, 0.1);
}

/* Card Styling */
.card {
    border-radius: var(--border-radius-lg);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: none;
    background: var(--color-white);
    margin-bottom: 1.5rem;
}

.card-body {
    padding: 1.5rem;
}

/* Section Title */
.section-title {
    color: var(--color-primary);
    font-weight: 700;
    margin-bottom: 0.5rem;
    border-left: 4px solid var(--color-accent);
    padding-left: 15px;
}

/* Button Styling */
.btn-primary, .btn-success, .btn-danger, .btn-warning, .btn-outline-primary, .btn-secondary {
    border-radius: var(--border-radius-sm);
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
}

.btn-primary:hover {
    background-color: var(--color-secondary);
    border-color: var(--color-secondary);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
    transform: translateY(-2px);
}

.btn-outline-primary {
    border: 2px solid var(--color-primary);
    color: var(--color-primary);
}

.btn-outline-primary:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-2px);
}

/* Form Styling */
.form-label {
    color: var(--color-primary);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.search-box {
    border-radius: var(--border-radius-sm);
    border: 2px solid var(--color-accent);
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.search-box:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 0.2rem rgba(224, 177, 203, 0.25);
}

.form-text {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.invalid-feedback {
    font-size: 0.85rem;
    color: var(--color-danger);
}

/* Responsive */
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 10px;
    }

    .d-flex.justify-content-between .btn {
        width: 100%;
    }
}
</style>

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

document.getElementById('no_telepon').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.startsWith('0')) {
        value = value.substring(1);
    }
    e.target.value = value;
});
</script>
@endsection

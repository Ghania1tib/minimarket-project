<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Saudara 2 - Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <style>
        :root {
            --color-primary: #5E548E;
            --color-secondary: #9F86C0;
            --color-accent: #E0B1CB;
            --color-danger: #E07A5F;
            --color-light: #F0E6EF;
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
            padding: 20px;
            position: relative;
            margin: 0;
        }

        /* Partikel Latar Belakang */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            background: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
        }

        .signup-container {
            width: 100%;
            max-width: 900px; /* Lebar maksimal diperbesar */
        }

        .signup-card {
            width: 100%;
            padding: 25px 30px; /* Padding disesuaikan */
            border-radius: 12px; /* Border radius lebih kecil */
            box-shadow: 0 8px 25px rgba(94, 84, 142, 0.12); /* Shadow lebih subtle */
            animation: fadeIn 0.8s ease-out;
            position: relative;
            z-index: 1;
            border: none;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(4px);
            display: flex;
            flex-direction: column;
            min-height: auto;
        }

        /* Header dengan Logo - Lebih Kompak */
        .signup-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(224, 224, 224, 0.5);
        }

         /* Header dengan Logo */
        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-container {
            margin-bottom: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            color: white;
            font-size: 1.8rem;
            font-weight: 800;
            border: 3px solid #9F86C0;
            box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);
        }

        .login-title {
            color: var(--color-primary);
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .login-subtitle {
            color: var(--color-secondary);
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
        }
        .signup-title {
            color: var(--color-primary);
            font-size: 1.4rem; /* Lebih kecil */
            font-weight: 800;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .signup-subtitle {
            color: var(--color-secondary);
            font-size: 0.85rem; /* Lebih kecil */
            font-weight: 500;
            margin: 0;
        }

        /* Form Grid Layout - 2 Kolom */
        .form-content {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 kolom */
            gap: 20px; /* Gap lebih kecil */
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px; /* Margin lebih kecil */
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem; /* Lebih kecil */
            margin-bottom: 5px;
            color:var(--color-primary);
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 10px 12px; /* Padding lebih kecil */
            border-radius: 8px; /* Radius lebih kecil */
            border: 1.5px solid #e0e0e0;
            font-size: 0.9rem; /* Font lebih kecil */
            transition: all 0.3s;
            background-color: #fafafa;
            box-sizing: border-box;
            height: 40px; /* Tinggi tetap */
        }

        .form-input:focus {
            outline: none;
            border-color: var(--color-primary);
            background-color: white;
            box-shadow: 0 0 0 2px rgba(94, 84, 142, 0.1);
        }

        /* Password field tetap full width */
        .full-width {
            grid-column: 1 / -1; /* Span 2 kolom */
        }

        /* Tombol Signup */
        .btn-signup {
            width: 100%;
            padding: 12px; /* Lebih kecil */
            background-color: var(--color-primary);
            border: none;
            border-radius: 8px; /* Radius lebih kecil */
            color: white;
            font-size: 0.95rem; /* Lebih kecil */
            font-weight: 700;
            transition: all 0.3s;
            margin: 10px 0 20px 0; /* Margin disesuaikan */
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(94, 84, 142, 0.2);
            grid-column: 1 / -1; /* Span 2 kolom */
        }

        .btn-signup:hover {
            background-color: #4a4277;
            transform: translateY(-1px);
            box-shadow: 0 5px 12px rgba(94, 84, 142, 0.3);
        }

        .btn-signup i {
            margin-right: 8px;
        }

        /* Link Section */
        .link-section {
            text-align: center;
            font-size: 0.85rem; /* Lebih kecil */
            color: #666;
            margin-bottom: 12px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            grid-column: 1 / -1; /* Span 2 kolom */
        }

        .link-section a {
            color: var(--color-secondary);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s;
        }

        .link-section a:hover {
            color: var(--color-primary);
            text-decoration: underline;
        }

        /* Back Link */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-align: center;
            font-size: 0.85rem; /* Lebih kecil */
            color: var(--color-secondary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
            padding-top: 15px;
            border-top: 1px solid #eee;
            grid-column: 1 / -1; /* Span 2 kolom */
        }

        .back-link:hover {
            color: var(--color-primary);
            text-decoration: none;
        }

        /* Alert Messages */
        .alert-box {
            border-radius: 8px; /* Lebih kecil */
            font-size: 0.8rem; /* Lebih kecil */
            padding: 8px 10px; /* Lebih kecil */
            margin-bottom: 15px;
            grid-column: 1 / -1; /* Span 2 kolom */
        }

        .alert-danger {
            background-color: #ffeaea;
            color: #b00020;
            border: 1px solid #ffcdd2;
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        /* Error Messages */
        .error-message {
            color: var(--color-danger);
            font-size: 0.75rem; /* Lebih kecil */
            margin-top: 3px;
            display: block;
        }

        /* Form Help Text */
        .form-text {
            font-size: 0.75rem; /* Lebih kecil */
            color: #888;
            margin-top: 3px;
            display: block;
        }

        /* Input Icons */
        .input-icon {
            color: var(--color-accent);
            margin-right: 6px;
            width: 14px; /* Lebih kecil */
            font-size: 0.85rem; /* Lebih kecil */
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .form-content {
                grid-template-columns: 1fr; /* 1 kolom di mobile */
                gap: 15px;
            }

            .signup-container {
                max-width: 450px;
            }

            .signup-card {
                padding: 20px;
            }

            body {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .signup-container {
                max-width: 100%;
            }

            .signup-card {
                padding: 18px 15px;
            }

            .form-input {
                padding: 9px 10px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>

    <div class="signup-container">
        <div class="signup-card">
            <!-- Header dengan Logo -->
            <div class="signup-header">
                <div class="logo-container">
                    <div class="logo">
                        <img src="{{ asset('storage/logo-toko.png') }}" alt="Toko Saudara Logo" height="60">
                    </div>
                </div>
                <h1 class="signup-title">TOKO SAUDARA 2</h1>
                <p class="signup-subtitle">Buat akun baru Anda</p>
            </div>

            <!-- Error/Success Messages -->
            @if ($errors->any())
                <div class="alert-box alert-danger" role="alert">
                    <ul class="mb-0 ps-3" style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert-box alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Signup dengan Grid Layout -->
            <form action="{{ route('submit.signup') }}" method="POST">
                @csrf

                <div class="form-content">
                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label for="nama_lengkap" class="form-label">
                            <i class="fas fa-user input-icon"></i>Nama Lengkap
                        </label>
                        <input type="text"
                               class="form-input @error('nama_lengkap') is-invalid @enderror"
                               id="nama_lengkap"
                               name="nama_lengkap"
                               required
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('nama_lengkap') }}">
                        @error('nama_lengkap')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope input-icon"></i>Alamat Email
                        </label>
                        <input type="email"
                               class="form-input @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               required
                               placeholder="contoh@domain.com"
                               value="{{ old('email') }}">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group full-width">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock input-icon"></i>Kata Sandi
                        </label>
                        <input type="password"
                               class="form-input @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               required
                               placeholder="Minimal 8 karakter">
                        <span class="form-text">
                            Harus mengandung huruf besar, huruf kecil, dan angka
                        </span>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- No Telepon -->
                    <div class="form-group">
                        <label for="no_telepon" class="form-label">
                            <i class="fas fa-phone input-icon"></i>Nomor Telepon
                        </label>
                        <input type="text"
                               class="form-input @error('no_telepon') is-invalid @enderror"
                               id="no_telepon"
                               name="no_telepon"
                               required
                               placeholder="No. telepon"
                               value="{{ old('no_telepon') }}">
                        @error('no_telepon')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="form-group">
                        <label for="alamat" class="form-label">
                            <i class="fas fa-home input-icon"></i>Alamat
                        </label>
                        <input type="text"
                               class="form-input @error('alamat') is-invalid @enderror"
                               id="alamat"
                               name="alamat"
                               required
                               placeholder="Alamat lengkap"
                               value="{{ old('alamat') }}">
                        @error('alamat')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Signup Button -->
                    <button type="submit" class="btn-signup">
                        <i class="fas fa-user-plus"></i>Daftar Sekarang
                    </button>

                    <!-- Link Login -->
                    <div class="link-section">
                        Sudah punya akun?
                        <a href="{{ route('login') }}">Masuk di sini</a>
                    </div>

                    <!-- Link Kembali -->
                    <a href="/" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Konfigurasi particles.js sama seperti di halaman login
        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: ["#5E548E", "#9F86C0", "#E0B1CB", "#E07A5F"]
                },
                shape: {
                    type: "edge",
                    stroke: {
                        width: 2,
                        color: "#9F86C0"
                    },
                    polygon: {
                        nb_sides: 5
                    }
                },
                opacity: {
                    value: 0.5,
                    random: false,
                    anim: {
                        enable: false,
                        speed: 1,
                        opacity_min: 0.1,
                        sync: false
                    }
                },
                size: {
                    value: 3,
                    random: true,
                    anim: {
                        enable: false,
                        speed: 40,
                        size_min: 0.1,
                        sync: false
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#9F86C0",
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 6,
                    direction: "none",
                    random: false,
                    straight: false,
                    out_mode: "out",
                    bounce: false,
                    attract: {
                        enable: false,
                        rotateX: 600,
                        rotateY: 1200
                    }
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: {
                        enable: true,
                        mode: "repulse"
                    },
                    onclick: {
                        enable: true,
                        mode: "push"
                    },
                    resize: true
                },
                modes: {
                    grab: {
                        distance: 969.1854853505416,
                        line_linked: {
                            opacity: 1
                        }
                    },
                    bubble: {
                        distance: 514.5058749391765,
                        size: 335.0270813557428,
                        duration: 2.4728189338161966,
                        opacity: 8,
                        speed: 3
                    },
                    repulse: {
                        distance: 200,
                        duration: 0.4
                    },
                    push: {
                        particles_nb: 4
                    },
                    remove: {
                        particles_nb: 2
                    }
                }
            },
            retina_detect: true
        });

        // Efek fokus pada input
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = 'var(--color-primary)';
                this.style.boxShadow = '0 0 0 2px rgba(94, 84, 142, 0.1)';
            });

            input.addEventListener('blur', function() {
                this.style.borderColor = '';
                this.style.boxShadow = '';
            });
        });
    </script>
</body>
</html>

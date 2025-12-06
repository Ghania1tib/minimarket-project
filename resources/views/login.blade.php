<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Saudara 2 - Login</title>
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
            padding: 15px;
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
        .login-container {
            width: 100%;
            max-width: 380px;
        }

        .login-card {
            width: 100%;
            padding: 30px 25px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(94, 84, 142, 0.15);
            animation: fadeIn 0.8s ease-out;
            position: relative;
            z-index: 1;
            border: none;
            background-color: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(5px);
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
            width: 70px;
            height: 70px;
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

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 6px;
            color: var(--color-primary);
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: 1.5px solid #e0e0e0;
            font-size: 0.95rem;
            transition: all 0.3s;
            background-color: #fafafa;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--color-primary);
            background-color: white;
            box-shadow: 0 0 0 2px rgba(94, 84, 142, 0.1);
        }

        /* Tombol Login */
        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: var(--color-primary);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            font-weight: 700;
            transition: all 0.3s;
            margin-top: 10px;
            margin-bottom: 25px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(94, 84, 142, 0.2);
        }

        .btn-login:hover {
            background-color: #4a4277;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(94, 84, 142, 0.3);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #999;
            font-size: 0.85rem;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #ddd, transparent);
        }

        .divider-text {
            padding: 0 12px;
            background: white;
        }

        /* Tombol Google */
        .btn-google {
            width: 100%;
            padding: 12px;
            background-color: white;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            color: var(--color-secondary);
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s;
            margin-bottom: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-google:hover {
            border-color: var(--color-primary);
            background-color: var(--color-light);
        }

        .btn-google i {
            color: var(--color-primary);
            font-size: 1rem;
        }

        /* Link Section */
        .link-section {
            text-align: center;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
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
            font-size: 0.9rem;
            color: var(--color-secondary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .back-link:hover {
            color: var(--color-primary);
            text-decoration: none;
        }

        /* Alert Messages */
        .alert-box {
            border-radius: 10px;
            font-size: 0.85rem;
            padding: 10px 12px;
            margin-bottom: 20px;
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
            font-size: 0.8rem;
            margin-top: 4px;
            display: block;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>

    <div class="login-container">
        <div class="login-card">
            <!-- Header dengan Logo -->
            <div class="login-header">
                <div class="logo-container">
                    <div class="logo">
                        <img src="{{ asset('storage/logo-toko.png') }}" alt="Toko Saudara Logo" height="60">
                    </div>
                </div>
                <h1 class="login-title">TOKO SAUDARA 2</h1>
                <p class="login-subtitle">Silakan masuk ke akun Anda</p>
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

            <!-- Form Login -->
            <form action="{{ route('submit.login') }}" method="POST">
                @csrf

                <!-- Username/Email -->
                <div class="form-group">
                    <label for="email" class="form-label" class="">Alamat Email</label>
                    <input type="email"
                           class="form-input @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           required
                           placeholder="Masukkan username atau email"
                           value="{{ old('email') }}">
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password"
                           class="form-input @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           required
                           placeholder="Masukkan password">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-login">
                    Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <div class="divider-line"></div>
                <div class="divider-text">Atau masuk dengan</div>
                <div class="divider-line"></div>
            </div>

            <!-- Google Login -->
            <a href="{{ route('google.login') }}" class="btn-google">
                <i class="fab fa-google"></i>
                Masuk dengan Google
            </a>

            <!-- Link Daftar -->
            <div class="link-section">
                Belum punya akun?
                <a href="{{ route('signup') }}">Daftar di sini</a>
            </div>

            <!-- Link Kembali -->
            <a href="/" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Halaman Utama
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
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
                value: ["#5E548E", "#9F86C0", "#E0B1CB", "#E07A5F"] // Menggunakan warna tema Anda
            },
            shape: {
                type: "edge", // Menggunakan edge seperti di JSON
                stroke: {
                    width: 2, // Mengurangi width agar tidak terlalu tebal
                    color: "#9F86C0" // Menggunakan warna tema
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
                color: "#9F86C0", // Menggunakan warna tema
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
                this.style.boxShadow = '0 0 0 3px rgba(94, 84, 142, 0.1)';
            });

            input.addEventListener('blur', function() {
                this.style.borderColor = '';
                this.style.boxShadow = '';
            });
        });
    </script>
</body>
</html>

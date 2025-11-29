<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Toko Saudara 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --sidebar-width: 280px;
            --color-primary: #5E548E;
            --color-secondary: #9F86C0;
            --color-accent: #E0B1CB;
            --color-danger: #E07A5F;
            --color-success: #70C1B3;
            --color-light: #F0E6EF;
            --color-white: #ffffff;
            --gradient-bg: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --border-radius-lg: 15px;
            --border-radius-sm: 8px;
        }

        body {
            margin: 0;
            padding: 0;
            background: var(--gradient-bg);
            font-family: var(--font-family);
            min-height: 100vh;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: margin-left 0.3s ease;
            background: var(--gradient-bg);
            min-height: 100vh;
        }

        /* Alert styling */
        .alert-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show alert-fixed" role="alert">
            <strong>Error:</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show alert-fixed" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-fixed" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="main-wrapper">
        <!-- Sidebar akan di-include di sini -->
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'owner')
            @include('layouts.sidebar-admin')
        @elseif(Auth::user()->role === 'kasir' || Auth::user()->role === 'staff')
            @include('layouts.sidebar-kasir')
        @endif

        <div class="content-wrapper">
            <!-- Main Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-fixed');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>

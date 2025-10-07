<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Member - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .member-card {
            max-width: 900px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); /* Bayangan diperkuat */
        }
        .card-header {
            background-color: #ffb6c1 !important;
            color: #004f7c !important;
            border-radius: 15px 15px 0 0;
            font-weight: bold;
        }
        .tab-content {
            padding-top: 20px;
        }

        /* Styling Tabs Navigasi */
        .nav-tabs .nav-link {
            color: #004f7c;
            border-top: 3px solid transparent;
            border-radius: 0;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            color: #ff6347; /* Warna cerah saat aktif */
            border-color: #ff6347; /* Border bawah warna cerah */
            background-color: #fff;
            border-radius: 0;
        }

        /* Styling Tombol */
        .btn-primary {
            background-color: #004f7c;
            border-color: #004f7c;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #003366;
            border-color: #003366;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="card member-card">
        <div class="card-header text-center p-3">
            <h4 class="mb-0"><i class="fas fa-users me-2"></i> KELOLA KARTU MEMBER</h4>
        </div>
        <div class="card-body p-4">
            <ul class="nav nav-tabs" id="memberTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="search-tab" data-bs-toggle="tab" data-bs-target="#search-area" type="button" role="tab"><i class="fas fa-search me-2"></i> Cari Member</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-area" type="button" role="tab"><i class="fas fa-user-plus me-2"></i> Daftar Baru</button>
                </li>
            </ul>

            <div class="tab-content" id="memberTabContent">
                <div class="tab-pane fade show active" id="search-area" role="tabpanel">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan Nama, Nomor Telepon, atau ID Member">
                        <button class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                    </div>

                    <div class="alert alert-success mt-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p class="mb-1 fw-bold">Member Ditemukan: Ani Susanti</p>
                                <p class="mb-0 small">ID: MB00123 | Telepon: 0812xxxx</p>
                            </div>
                            <div class="col-4 text-end">
                                <h4 class="mb-0 text-success"><i class="fas fa-star me-1"></i> 250 Poin</h4>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-outline-primary btn-sm"><i class="fas fa-edit me-1"></i> Lihat Detail Member</button>
                    </div>
                </div>

                <div class="tab-pane fade" id="register-area" role="tabpanel">
                    <form action="/member/store" method="POST">
                        @csrf <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" name="phone" required>
                            <small class="form-text text-muted">Akan digunakan sebagai ID member sementara.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email (Opsional)</label>
                            <input type="email" class="form-control" name="email">
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-user-check me-2"></i> Simpan Member Baru</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('dashboard.staff') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

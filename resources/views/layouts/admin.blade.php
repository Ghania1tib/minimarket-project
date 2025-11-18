<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Minimarket</title>

    <style>
        /* Global Styling untuk Tema Dashboard */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5 !important;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Container ini akan berlaku untuk SEMUA halaman admin */
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Header Section */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .header-section h2 {
            font-size: 28px;
            color: #34495e;
            margin: 0;
        }

        /* Tombol Tambah Kategori */
        .btn-tambah {
            padding: 12px 25px;
            background-color: #007bff;
            /* Biru cerah */
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
        }

        .btn-tambah:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        /* Alert Sukses */
        .alert-success {
            padding: 15px 20px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .alert-success::before {
            content: '✓';
            font-size: 20px;
            margin-right: 10px;
            color: #28a745;
        }

        /* Table Styling */
        .kategori-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .kategori-table thead {
            background-color: #e9ecef;
            color: #495057;
        }

        .kategori-table th,
        .kategori-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .kategori-table th:first-child,
        .kategori-table td:first-child {
            border-left: 1px solid #dee2e6;
        }

        .kategori-table th:last-child,
        .kategori-table td:last-child {
            border-right: 1px solid #dee2e6;
        }

        .kategori-table thead th:first-child {
            border-top-left-radius: 10px;
        }

        .kategori-table thead th:last-child {
            border-top-right-radius: 10px;
        }

        .kategori-table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        .kategori-table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }

        .kategori-table tbody tr:last-child td {
            border-bottom: none;
        }


        .kategori-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .kategori-table td img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }

        .kategori-table td a {
            text-decoration: none;
            margin-right: 10px;
            font-weight: 500;
        }

        .kategori-table td a.edit-link {
            color: #007bff;
        }

        .kategori-table td a.delete-link {
            color: #dc3545;
        }

        .kategori-table td a:hover {
            text-decoration: underline;
        }

        .empty-message {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-style: italic;
        }
    </style>

</head>

<body>

    {{-- Nanti Anda bisa tambahkan Sidebar di sini --}}
    {{-- <div class="sidebar">...</div> --}}

    <div class="main-content">
        {{-- Ini adalah "slot" tempat index.blade.php dimasukkan --}}
        @yield('content')
    </div>

</body>

</html>
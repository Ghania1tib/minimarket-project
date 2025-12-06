@extends('layouts.admin')

@section('title', 'Riwayat Stok')

@section('content')
<div class="container">
    <div class="header-section">
        <h2><i class="fas fa-history"></i> Riwayat Stok</h2>
        <div class="header-actions">
            <button class="btn-tambah" id="addStockBtn">
                <i class="fas fa-plus"></i> Tambah Stok
            </button>
            <button class="btn-tambah" id="exportBtn" style="background-color: #28a745;">
                <i class="fas fa-download"></i> Export
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Section -->
    <div class="filters-section">
        <div class="filter-group">
            <label for="dateFilter">Tanggal:</label>
            <input type="date" id="dateFilter" class="filter-input">
        </div>
        <div class="filter-group">
            <label for="productFilter">Produk:</label>
            <select id="productFilter" class="filter-input">
                <option value="">Semua Produk</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label for="typeFilter">Jenis:</label>
            <select id="typeFilter" class="filter-input">
                <option value="">Semua Jenis</option>
                <option value="in">Penambahan</option>
                <option value="out">Pengurangan</option>
            </select>
        </div>
        <button class="btn-filter" id="resetFilters">
            <i class="fas fa-refresh"></i> Reset
        </button>
    </div>

    <!-- Stock History Table -->
    <div class="table-responsive">
        <table class="kategori-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produk</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Stok Sebelum</th>
                    <th>Stok Sesudah</th>
                    <th>User</th>
                    <th>Order ID</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stockHistory as $history)
                    <tr>
                        <td>{{ $history->id }}</td>
                        <td>{{ $history->product->nama ?? 'Produk Dihapus' }}</td>
                        <td>
                            <span class="badge {{ $history->jumlah_perubahan >= 0 ? 'badge-success' : 'badge-danger' }}">
                                {{ $history->jumlah_perubahan >= 0 ? 'Penambahan' : 'Pengurangan' }}
                            </span>
                        </td>
                        <td class="{{ $history->jumlah_perubahan >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $history->jumlah_perubahan >= 0 ? '+' : '' }}{{ $history->jumlah_perubahan }}
                        </td>
                        <td>{{ $history->stok_sebelum }}</td>
                        <td>{{ $history->stok_sesudah }}</td>
                        <td>{{ $history->user->name ?? 'User Dihapus' }}</td>
                        <td>{{ $history->order_id ?? '-' }}</td>
                        <td>{{ $history->tanggal_perubahan->format('d/m/Y H:i') }}</td>
                        <td>
                            <button class="btn-action btn-edit" data-id="{{ $history->id }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action btn-delete" data-id="{{ $history->id }}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="empty-message">
                            <i class="fas fa-inbox"></i> Tidak ada data riwayat stok
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($stockHistory->hasPages())
        <div class="pagination-container">
            {{ $stockHistory->links() }}
        </div>
    @endif
</div>

<!-- Add/Edit Stock Modal -->
<div id="stockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Perubahan Stok</h3>
            <span class="close">&times;</span>
        </div>
        <form id="stockForm" method="POST">
            @csrf
            <div id="formMethod" style="display: none;"></div>
            
            <div class="form-group">
                <label for="product_id">Produk *</label>
                <select name="product_id" id="product_id" required class="form-input">
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-stock="{{ $product->stok }}">
                            {{ $product->nama }} (Stok: {{ $product->stok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="jumlah_perubahan">Jumlah Perubahan *</label>
                <input type="number" name="jumlah_perubahan" id="jumlah_perubahan" required class="form-input" 
                       placeholder="Gunakan minus (-) untuk pengurangan">
                <small class="form-text">Masukkan angka positif untuk penambahan, negatif untuk pengurangan</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="stok_sebelum">Stok Sebelum</label>
                    <input type="number" name="stok_sebelum" id="stok_sebelum" readonly class="form-input">
                </div>
                <div class="form-group">
                    <label for="stok_sesudah">Stok Sesudah</label>
                    <input type="number" name="stok_sesudah" id="stok_sesudah" readonly class="form-input">
                </div>
            </div>

            <div class="form-group">
                <label for="order_id">Order ID (Opsional)</label>
                <input type="text" name="order_id" id="order_id" class="form-input" 
                       placeholder="ID pesanan terkait">
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-input" 
                          placeholder="Keterangan perubahan stok"></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-cancel" id="cancelBtn">Batal</button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Konfirmasi Hapus</h3>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus riwayat stok ini?</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="form-actions">
                    <button type="button" class="btn-cancel" id="cancelDelete">Batal</button>
                    <button type="submit" class="btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .filters-section {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        flex-wrap: wrap;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-weight: 500;
        font-size: 14px;
        color: #495057;
    }

    .filter-input, .form-input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .btn-filter {
        padding: 8px 15px;
        background: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        height: fit-content;
    }

    .btn-filter:hover {
        background: #5a6268;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .text-success { color: #28a745; }
    .text-danger { color: #dc3545; }

    .btn-action {
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: 0 2px;
        font-size: 14px;
    }

    .btn-edit {
        background: #007bff;
        color: white;
    }

    .btn-edit:hover {
        background: #0056b3;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        width: 90%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }

    .modal-header h3 {
        margin: 0;
        color: #34495e;
    }

    .close {
        font-size: 24px;
        cursor: pointer;
        color: #999;
    }

    .close:hover {
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
        padding: 0 20px;
    }

    .form-row {
        display: flex;
        gap: 15px;
        padding: 0 20px;
    }

    .form-row .form-group {
        flex: 1;
        padding: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #495057;
    }

    .form-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 15px 20px;
        border-top: 1px solid #eee;
    }

    .btn-cancel {
        padding: 8px 15px;
        background: #6c757d;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-submit {
        padding: 8px 15px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-danger {
        padding: 8px 15px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .filters-section {
            flex-direction: column;
        }
        
        .filter-group {
            width: 100%;
        }
        
        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('stockModal');
    const deleteModal = document.getElementById('deleteModal');
    const closeButtons = document.querySelectorAll('.close');
    const cancelBtn = document.getElementById('cancelBtn');
    const cancelDelete = document.getElementById('cancelDelete');
    const addStockBtn = document.getElementById('addStockBtn');
    const stockForm = document.getElementById('stockForm');
    const deleteForm = document.getElementById('deleteForm');
    const productSelect = document.getElementById('product_id');
    const jumlahInput = document.getElementById('jumlah_perubahan');
    const stokSebelumInput = document.getElementById('stok_sebelum');
    const stokSesudahInput = document.getElementById('stok_sesudah');

    // Filter elements
    const dateFilter = document.getElementById('dateFilter');
    const productFilter = document.getElementById('productFilter');
    const typeFilter = document.getElementById('typeFilter');
    const resetFilters = document.getElementById('resetFilters');

    // Open Add Modal
    addStockBtn.addEventListener('click', function() {
        document.getElementById('modalTitle').textContent = 'Tambah Perubahan Stok';
        stockForm.reset();
        stockForm.action = "{{ route('admin.stock-history.store') }}";
        document.getElementById('formMethod').innerHTML = '';
        modal.style.display = 'block';
    });

    // Close Modals
    function closeModals() {
        modal.style.display = 'none';
        deleteModal.style.display = 'none';
    }

    closeButtons.forEach(btn => btn.addEventListener('click', closeModals));
    cancelBtn.addEventListener('click', closeModals);
    cancelDelete.addEventListener('click', closeModals);

    // Calculate stock changes
    function calculateStock() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const currentStock = parseInt(selectedOption?.getAttribute('data-stock')) || 0;
        const change = parseInt(jumlahInput.value) || 0;
        
        stokSebelumInput.value = currentStock;
        stokSesudahInput.value = currentStock + change;
    }

    productSelect.addEventListener('change', calculateStock);
    jumlahInput.addEventListener('input', calculateStock);

    // Edit buttons
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            // Implement edit functionality
            // This would typically fetch data via AJAX
            console.log('Edit stock history:', id);
        });
    });

    // Delete buttons
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            deleteForm.action = `/admin/stock-history/${id}`;
            deleteModal.style.display = 'block';
        });
    });

    // Filter functionality
    function applyFilters() {
        const params = new URLSearchParams();
        
        if (dateFilter.value) params.append('date', dateFilter.value);
        if (productFilter.value) params.append('product', productFilter.value);
        if (typeFilter.value) params.append('type', typeFilter.value);
        
        window.location.href = '{{ route("admin.stock-history.index") }}?' + params.toString();
    }

    dateFilter.addEventListener('change', applyFilters);
    productFilter.addEventListener('change', applyFilters);
    typeFilter.addEventListener('change', applyFilters);

    resetFilters.addEventListener('click', function() {
        window.location.href = '{{ route("admin.stock-history.index") }}';
    });

    // Set current date as default for date filter
    dateFilter.value = new Date().toISOString().split('T')[0];
});
</script>
@endsection
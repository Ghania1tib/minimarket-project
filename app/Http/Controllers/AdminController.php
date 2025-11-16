<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */
    public function dashboard()
    {
        // Data statistik
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
            'low_stock_products' => Product::whereColumn('stok', '<=', 'stok_kritis')->count(),
            'today_sales' => $this->getTodaySales(),
            'monthly_revenue' => $this->getMonthlyRevenue(),
            'recent_orders' => $this->getRecentOrders(),
            'popular_products' => $this->getPopularProducts(),
            'sales_chart_data' => $this->getSalesChartData(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Mendapatkan total penjualan hari ini
     */
    private function getTodaySales()
    {
        return Order::whereDate('created_at', Carbon::today())
            ->where('status_pesanan', 'selesai')
            ->count();
    }

    /**
     * Mendapatkan pendapatan bulan ini
     */
    private function getMonthlyRevenue()
    {
        return Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('status_pesanan', 'selesai')
            ->sum('total_bayar');
    }

    /**
     * Mendapatkan pesanan terbaru
     */
    private function getRecentOrders($limit = 5)
    {
        return Order::with(['user' => function($query) {
                $query->select('id', 'nama_lengkap');
            }])
            ->where('status_pesanan', 'selesai')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Mendapatkan produk terpopuler
     */
    private function getPopularProducts($limit = 4)
    {
        return Product::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Mendapatkan data untuk chart penjualan
     */
    private function getSalesChartData()
    {
        $salesData = Order::where('status_pesanan', 'selesai')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as transactions'),
                DB::raw('SUM(total_bayar) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Format data untuk chart
        $labels = [];
        $revenue = [];
        $transactions = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayName = Carbon::now()->subDays($i)->translatedFormat('D');

            $labels[] = $dayName;

            $dailyData = $salesData->where('date', $date)->first();
            $revenue[] = $dailyData ? $dailyData->revenue : 0;
            $transactions[] = $dailyData ? $dailyData->transactions : 0;
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'transactions' => $transactions
        ];
    }

    /**
     * Menampilkan laporan penjualan
     */
    public function salesReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $orders = Order::with(['user', 'orderItems.product'])
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->where('status_pesanan', 'selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $orders->sum('total_bayar');
        $totalTransactions = $orders->count();

        return view('admin.sales-report', compact('orders', 'totalRevenue', 'totalTransactions', 'startDate', 'endDate'));
    }

    /**
     * Menampilkan riwayat stok
     */
    public function stockHistory(Request $request)
    {
        $productId = $request->get('product_id');

        $query = DB::table('stock_history')
            ->join('products', 'stock_history.product_id', '=', 'products.id')
            ->leftJoin('users', 'stock_history.user_id', '=', 'users.id')
            ->leftJoin('orders', 'stock_history.order_id', '=', 'orders.id')
            ->select(
                'stock_history.*',
                'products.nama_produk',
                'users.nama_lengkap as user_name',
                'orders.id as order_id'
            )
            ->orderBy('stock_history.tanggal_perubahan', 'desc');

        if ($productId) {
            $query->where('stock_history.product_id', $productId);
        }

        $stockHistory = $query->paginate(20);
        $products = Product::all();

        return view('admin.stock-history', compact('stockHistory', 'products'));
    }

    /**
     * Menampilkan analisis produk
     */
    public function productAnalysis()
    {
        // Produk terlaris
        $bestSellingProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.nama_produk',
                DB::raw('SUM(order_items.quantity) as total_terjual'),
                DB::raw('SUM(order_items.quantity * order_items.harga_saat_beli) as total_pendapatan')
            )
            ->groupBy('products.id', 'products.nama_produk')
            ->orderBy('total_terjual', 'desc')
            ->limit(10)
            ->get();

        // Kategori terpopuler
        $popularCategories = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.nama_kategori',
                DB::raw('SUM(order_items.quantity) as total_terjual')
            )
            ->groupBy('categories.id', 'categories.nama_kategori')
            ->orderBy('total_terjual', 'desc')
            ->get();

        // Stok menipis
        $lowStockProducts = Product::whereColumn('stok', '<=', 'stok_kritis')
            ->orderBy('stok', 'asc')
            ->get();

        return view('admin.product-analysis', compact('bestSellingProducts', 'popularCategories', 'lowStockProducts'));
    }

    /**
     * Export data laporan
     */
    public function exportData(Request $request)
    {
        $type = $request->get('type', 'sales');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Logic untuk export data akan ditambahkan kemudian
        // Untuk sini, kita redirect ke halaman yang sama dengan pesan
        return redirect()->back()->with('info', 'Fitur export data akan segera tersedia.');
    }

    /**
     * Menampilkan pengaturan sistem
     */
    public function systemSettings()
    {
        return view('admin.system-settings');
    }

    /**
     * Menyimpan pengaturan sistem
     */
    public function updateSystemSettings(Request $request)
    {
        // Validasi input
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string',
            'store_phone' => 'required|string|max:20',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        // Simpan pengaturan (bisa disimpan di database atau config file)
        // Untuk contoh, kita simpan di session
        session([
            'store_settings' => [
                'store_name' => $request->store_name,
                'store_address' => $request->store_address,
                'store_phone' => $request->store_phone,
                'tax_rate' => $request->tax_rate ?? 0,
            ]
        ]);

        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil disimpan!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashierReportController extends Controller
{
    public function cashierReport(Request $request)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        // Jika admin, redirect ke laporan penjualan admin
        if (Auth::user()->isAdmin() || Auth::user()->isOwner()) {
            return $this->adminSalesReport($request);
        }

        // Kode existing untuk kasir (tetap sama)
        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));

        $activeShift = Shift::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        $salesData = $this->getSalesData($tanggal);
        $weeklySales = $this->getWeeklySalesData();

        // TAMBAHKAN WITH USER UNTUK MENDAPATKAN NAMA KASIR
        $shiftHistory = Shift::where('user_id', Auth::id())
            ->where('status', 'closed')
            ->orderBy('waktu_selesai', 'desc')
            ->take(5)
            ->get();

        return view('cashier_report', compact(
            'activeShift',
            'salesData',
            'weeklySales',
            'shiftHistory',
            'tanggal'
        ));
    }

    /**
     * Laporan Penjualan untuk Admin
     */
    private function adminSalesReport(Request $request)
    {
        // Parameter filter
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $cashierId = $request->get('cashier_id');
        $paymentMethod = $request->get('payment_method');

        // Data ringkasan penjualan
        $summaryData = $this->getAdminSummaryData($startDate, $endDate, $cashierId);

        // Data penjualan harian untuk chart
        $dailySalesData = $this->getDailySalesData($startDate, $endDate, $cashierId);

        // Data metode pembayaran
        $paymentMethodData = $this->getPaymentMethodData($startDate, $endDate, $cashierId);

        // Data kasir
        $cashiers = User::whereIn('role', ['kasir', 'admin'])->get();

        // Riwayat shift semua kasir
        $allShiftHistory = Shift::where('status', 'closed')
            ->whereBetween('waktu_selesai', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('waktu_selesai', 'desc')
            ->take(10)
            ->get();

        return view('admin_sales_report', compact(
            'summaryData',
            'dailySalesData',
            'paymentMethodData',
            'allShiftHistory',
            'cashiers',
            'startDate',
            'endDate',
            'cashierId',
            'paymentMethod'
        ));
    }

    /**
     * Data Ringkasan untuk Admin
     */
    private function getAdminSummaryData($startDate, $endDate, $cashierId = null)
    {
        $query = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status_pesanan', 'selesai');

        if ($cashierId) {
            $query->where('user_id', $cashierId);
        }

        return $query->select(
            DB::raw('COALESCE(SUM(subtotal), 0) as total_penjualan_kotor'),
            DB::raw('COALESCE(SUM(total_diskon), 0) as total_diskon'),
            DB::raw('COALESCE(SUM(total_bayar), 0) as total_penjualan_bersih'),
            DB::raw('COUNT(*) as total_transaksi'),
            DB::raw('COALESCE(AVG(total_bayar), 0) as rata_rata_transaksi')
        )->first();
    }

    /**
     * Data Penjualan Harian untuk Chart
     */
    private function getDailySalesData($startDate, $endDate, $cashierId = null)
    {
        $query = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status_pesanan', 'selesai');

        if ($cashierId) {
            $query->where('user_id', $cashierId);
        }

        $dailyData = $query->select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COALESCE(SUM(total_bayar), 0) as total_penjualan'),
            DB::raw('COUNT(*) as total_transaksi')
        )
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

        // Format data untuk chart
        $labels = [];
        $sales = [];
        $transactions = [];

        $currentDate = Carbon::parse($startDate);
        $endDateObj = Carbon::parse($endDate);

        while ($currentDate <= $endDateObj) {
            $dateStr = $currentDate->format('Y-m-d');
            $labels[] = $currentDate->locale('id')->translatedFormat('d M');

            $data = $dailyData->firstWhere('tanggal', $dateStr);
            $sales[] = $data ? (float) $data->total_penjualan : 0;
            $transactions[] = $data ? $data->total_transaksi : 0;

            $currentDate->addDay();
        }

        return [
            'labels' => $labels,
            'sales' => $sales,
            'transactions' => $transactions
        ];
    }

    /**
     * Data Metode Pembayaran
     */
    private function getPaymentMethodData($startDate, $endDate, $cashierId = null)
    {
        $query = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status_pesanan', 'selesai');

        if ($cashierId) {
            $query->where('user_id', $cashierId);
        }

        return $query->select(
            'metode_pembayaran',
            DB::raw('COALESCE(SUM(total_bayar), 0) as total'),
            DB::raw('COUNT(*) as jumlah_transaksi')
        )
        ->groupBy('metode_pembayaran')
        ->get();
    }

    private function getSalesData($tanggal)
    {
        $sales = Order::whereDate('created_at', $tanggal)
            ->where('status_pesanan', 'selesai')
            ->select(
                DB::raw('COALESCE(SUM(subtotal), 0) as total_penjualan'),
                DB::raw('COALESCE(SUM(total_diskon), 0) as total_diskon'),
                DB::raw('COALESCE(SUM(total_bayar), 0) as total_bayar'),
                DB::raw('COUNT(*) as total_transaksi'),
                'metode_pembayaran'
            )
            ->groupBy('metode_pembayaran')
            ->get();

        // Format data untuk tampilan
        $result = [
            'total_penjualan_kotor' => 0,
            'total_transaksi' => 0,
            'tunai' => 0,
            'debit_kredit' => 0,
            'qris_ewallet' => 0,
            'total_diskon' => 0,
            'total_bayar_bersih' => 0
        ];

        foreach ($sales as $sale) {
            $result['total_penjualan_kotor'] += $sale->total_penjualan;
            $result['total_transaksi'] += $sale->total_transaksi;
            $result['total_diskon'] += $sale->total_diskon;
            $result['total_bayar_bersih'] += $sale->total_bayar;

            switch ($sale->metode_pembayaran) {
                case 'tunai':
                    $result['tunai'] = $sale->total_bayar;
                    break;
                case 'debit_kredit':
                    $result['debit_kredit'] = $sale->total_bayar;
                    break;
                case 'qris_ewallet':
                    $result['qris_ewallet'] = $sale->total_bayar;
                    break;
            }
        }

        return $result;
    }

    private function getWeeklySalesData()
    {
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $weeklyData = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status_pesanan', 'selesai')
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COALESCE(SUM(total_bayar), 0) as total_penjualan'),
                DB::raw('COUNT(*) as total_transaksi')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Format untuk chart
        $labels = [];
        $sales = [];
        $transactions = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayName = Carbon::now()->subDays($i)->locale('id')->translatedFormat('D');
            $labels[] = $dayName;

            $data = $weeklyData->firstWhere('tanggal', $date);
            $sales[] = $data ? (float) $data->total_penjualan : 0;
            $transactions[] = $data ? $data->total_transaksi : 0;
        }

        return [
            'labels' => $labels,
            'sales' => $sales,
            'transactions' => $transactions
        ];
    }

    public function closeShift(Request $request)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        $request->validate([
            'uang_fisik_di_kasir' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $activeShift = Shift::where('user_id', Auth::id())
                ->where('status', 'active')
                ->firstOrFail();

            $today = now()->format('Y-m-d');
            $salesData = $this->getSalesData($today);

            // Hitung selisih
            $totalKasHarusnya = $activeShift->modal_awal + $salesData['tunai'];
            $selisih = $request->uang_fisik_di_kasir - $totalKasHarusnya;

            // Update shift dengan data penjualan
            $activeShift->update([
                'total_tunai_sistem' => $salesData['tunai'],
                'total_debit_sistem' => $salesData['debit_kredit'],
                'total_qris_sistem' => $salesData['qris_ewallet'],
                'uang_fisik_di_kasir' => $request->uang_fisik_di_kasir,
                'selisih' => $selisih,
                'waktu_selesai' => now(),
                'status' => 'closed',
                'catatan' => $request->catatan
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Shift berhasil ditutup!',
                'data' => [
                    'selisih' => $selisih,
                    'total_penjualan' => $salesData['total_penjualan_kotor'],
                    'total_transaksi' => $salesData['total_transaksi']
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menutup shift: ' . $e->getMessage()
            ], 422);
        }
    }

    public function startShift(Request $request)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        // Validasi manual untuk menghindari issue format angka
        $modalAwal = $request->modal_awal;
        $namaKasir = $request->nama_kasir; // TAMBAHKAN INI

        // Pastikan nilai adalah numerik
        if (!is_numeric($modalAwal)) {
            // Coba konversi dari string ke numeric
            $modalAwal = (float) str_replace(['.', ','], '', $modalAwal);
        }

        if ($modalAwal < 10000) {
            return response()->json([
                'success' => false,
                'message' => 'Modal awal minimal Rp 10.000'
            ], 422);
        }

        // Validasi nama kasir
        if (empty($namaKasir)) {
            return response()->json([
                'success' => false,
                'message' => 'Nama kasir harus diisi'
            ], 422);
        }

        // Cek apakah ada shift aktif
        $activeShift = Shift::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if ($activeShift) {
            return response()->json([
                'success' => false,
                'message' => 'Masih ada shift yang aktif. Tutup shift terlebih dahulu.'
            ], 422);
        }

        try {
            // Buat shift baru
            $shift = new Shift();
            $shift->user_id = Auth::id();
            $shift->nama_kasir = $namaKasir; // TAMBAHKAN INI
            $shift->modal_awal = $modalAwal;
            $shift->status = 'active';
            $shift->waktu_mulai = now();
            $shift->save();

            return response()->json([
                'success' => true,
                'message' => 'Shift berhasil dimulai!',
                'shift' => $shift
            ]);

        } catch (\Exception $e) {
            \Log::error('Error creating shift: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memulai shift: ' . $e->getMessage()
            ], 422);
        }
    }

    public function getShiftDetail($id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        $shift = Shift::findOrFail($id);

        // Pastikan shift milik user yang bersangkutan atau admin/owner
        if ($shift->user_id !== Auth::id() && !Auth::user()->isAdmin() && !Auth::user()->isOwner()) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        return response()->json([
            'success' => true,
            'shift' => $shift
        ]);
    }

    /**
     * Export Laporan Penjualan untuk Admin (Bonus Feature)
     */
    public function exportSalesReport(Request $request)
    {
        if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isOwner())) {
            abort(403, 'Unauthorized access.');
        }

        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $cashierId = $request->get('cashier_id');

        // Data untuk export
        $salesData = Order::with('user')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status_pesanan', 'selesai')
            ->when($cashierId, function($query) use ($cashierId) {
                return $query->where('user_id', $cashierId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $summaryData = $this->getAdminSummaryData($startDate, $endDate, $cashierId);

        // Return view untuk PDF export (bisa diimplementasikan dengan dompdf)
        return view('exports.sales_report', compact(
            'salesData',
            'summaryData',
            'startDate',
            'endDate'
        ));
    }
}

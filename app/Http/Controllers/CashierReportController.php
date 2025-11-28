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

        // Ambil parameter tanggal jika ada
        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));

        // Ambil shift aktif user saat ini
        $activeShift = Shift::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        // Hitung total penjualan berdasarkan tanggal
        $salesData = $this->getSalesData($tanggal);

        // Data untuk chart (7 hari terakhir)
        $weeklySales = $this->getWeeklySalesData();

        // Riwayat shift
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
            // Buat shift baru TANPA timestamps
            $shift = new Shift();
            $shift->user_id = Auth::id();
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

        $shift = Shift::with('user')->findOrFail($id);

        // Pastikan shift milik user yang bersangkutan atau admin/owner
        if ($shift->user_id !== Auth::id() && !Auth::user()->isAdmin() && !Auth::user()->isOwner()) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        return response()->json([
            'success' => true,
            'shift' => $shift
        ]);
    }
}

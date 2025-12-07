<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $orders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pelanggan.pesanan', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Generate timeline menggunakan method dari model Order
        $timeline = $order->getTimelineAttribute();

        return view('pelanggan.pesanan-detail', compact('order', 'timeline'));
    }

    public function batalkan($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Hanya bisa membatalkan jika status masih menunggu_pembayaran atau menunggu_verifikasi
        if (! in_array($order->status_pesanan, [
            Order::STATUS_PESANAN_MENUNGGU,
            Order::STATUS_PESANAN_VERIFIKASI,
        ])) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $order->update([
            'status_pesanan'    => Order::STATUS_PESANAN_DIBATALKAN,
            'status_pembayaran' => Order::STATUS_PEMBAYARAN_DITOLAK,
        ]);

        // Kembalikan stok produk
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stok', $item->quantity);
            }
        }

        Log::info('Order dibatalkan', ['order_id' => $order->id, 'user_id' => Auth::id()]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

/**
 * Konfirmasi pembayaran tunai
 */
    public function bayar($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Hanya bisa konfirmasi pembayaran tunai
        if ($order->metode_pembayaran != 'tunai') {
            return redirect()->back()->with('error', 'Hanya pembayaran tunai yang dapat dikonfirmasi melalui fitur ini.');
        }

        // Validasi status
        if ($order->status_pesanan != Order::STATUS_PESANAN_MENUNGGU) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dikonfirmasi karena sudah diproses.');
        }

        // Konfirmasi pembayaran tunai
        $order->update([
            'status_pembayaran'  => Order::STATUS_PEMBAYARAN_TERVERIFIKASI,
            'status_pesanan'     => Order::STATUS_PESANAN_SELESAI,
            'catatan_verifikasi' => 'Pembayaran tunai dikonfirmasi oleh customer pada ' . now()->toDateTimeString(),
            'updated_at'         => now(),
        ]);

        Log::info('Pembayaran tunai dikonfirmasi', [
            'order_id'          => $order->id,
            'user_id'           => Auth::id(),
            'status_pesanan'    => $order->status_pesanan,
            'status_pembayaran' => $order->status_pembayaran,
        ]);

        return redirect()->back()->with('success', 'Pembayaran tunai berhasil dikonfirmasi. Pesanan selesai.');
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'nomor_rekening'   => 'required_if:metode_pembayaran,transfer',
            'nama_bank'        => 'required_if:metode_pembayaran,transfer',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'nomor_rekening.required_if' => 'Nomor rekening wajib diisi untuk pembayaran transfer.',
            'nama_bank.required_if'      => 'Nama bank wajib diisi untuk pembayaran transfer.',
            'bukti_pembayaran.required'  => 'Bukti pembayaran wajib diupload.',
            'bukti_pembayaran.image'     => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes'     => 'Format file yang diperbolehkan: jpeg, png, jpg, gif, webp.',
            'bukti_pembayaran.max'       => 'Ukuran file maksimal 2MB.',
        ]);

        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Boleh upload bukti selama status pembayaran masih menunggu
        if ($order->status_pembayaran != Order::STATUS_PEMBAYARAN_MENUNGGU) {
            return redirect()->back()->with('error', 'Pembayaran sudah diproses atau tidak dapat diubah.');
        }

        // Upload bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $file     = $request->file('bukti_pembayaran');
            $filename = 'payment_' . time() . '_' . $order->id . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('bukti_pembayaran', $filename, 'public');

            $updateData = [
                'bukti_pembayaran'  => $path,
                'status_pembayaran' => Order::STATUS_PEMBAYARAN_VERIFIKASI,
                // INI YANG PERLU DIPERBAIKI: Update juga status_pesanan
                'status_pesanan'    => Order::STATUS_PESANAN_VERIFIKASI,
                'updated_at'        => now(),
            ];

            // Tambahkan info rekening untuk transfer
            if ($order->metode_pembayaran == 'transfer') {
                $updateData['nomor_rekening'] = $request->nomor_rekening;
                $updateData['nama_bank']      = $request->nama_bank;
            }

            $order->update($updateData);

            Log::info('Bukti pembayaran diupload', [
                'order_id'          => $order->id,
                'status_pesanan'    => $order->status_pesanan,
                'status_pembayaran' => $order->status_pembayaran,
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }

    public function riwayat()
    {
        $user   = Auth::user();
        $orders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pelanggan.riwayat', compact('orders'));
    }

    /**
     * Update status pesanan (untuk admin/kasir)
     */
    public function updateStatus(Request $request, $id)
    {
        // Middleware admin harus diterapkan di route
        if (! Auth::user()->hasRole('admin') && ! Auth::user()->hasRole('kasir')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengupdate status.');
        }

        $request->validate([
            'status_pesanan'     => 'required|in:' . implode(',', [
                Order::STATUS_PESANAN_VERIFIKASI,
                Order::STATUS_PESANAN_DIPROSES,
                Order::STATUS_PESANAN_DIKIRIM,
                Order::STATUS_PESANAN_SELESAI,
            ]),
            'catatan_verifikasi' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($id);

        $statusSebelumnya = $order->status_pesanan;

        $updateData = [
            'status_pesanan' => $request->status_pesanan,
            'updated_at'     => now(),
        ];

        // Tambahkan catatan jika ada
        if ($request->catatan_verifikasi) {
            $updateData['catatan_verifikasi'] = $request->catatan_verifikasi;
        }

        // Jika status berubah dari menunggu_verifikasi ke diproses, otomatis verifikasi pembayaran
        if ($statusSebelumnya == Order::STATUS_PESANAN_VERIFIKASI &&
            $request->status_pesanan == Order::STATUS_PESANAN_DIPROSES) {
            $updateData['status_pembayaran'] = Order::STATUS_PEMBAYARAN_TERVERIFIKASI;
        }

        // Jika status selesai, pastikan pembayaran sudah terverifikasi
        if ($request->status_pesanan == Order::STATUS_PESANAN_SELESAI &&
            $order->status_pembayaran != Order::STATUS_PEMBAYARAN_TERVERIFIKASI) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat diselesaikan karena pembayaran belum diverifikasi.');
        }

        $order->update($updateData);

        Log::info('Status pesanan diupdate', [
            'order_id'   => $order->id,
            'old_status' => $statusSebelumnya,
            'new_status' => $request->status_pesanan,
            'updated_by' => Auth::user()->id,
            'catatan'    => $request->catatan_verifikasi,
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Verifikasi pembayaran (untuk admin)
     */
    public function verifyPayment(Request $request, $id)
    {
        if (! Auth::user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'Hanya admin yang dapat memverifikasi pembayaran.');
        }

        $request->validate([
            'status_pembayaran'  => 'required|in:' . implode(',', [
                Order::STATUS_PEMBAYARAN_TERVERIFIKASI,
                Order::STATUS_PEMBAYARAN_DITOLAK,
            ]),
            'catatan_verifikasi' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($id);

        if ($order->status_pembayaran != Order::STATUS_PEMBAYARAN_VERIFIKASI) {
            return redirect()->back()->with('error', 'Pembayaran tidak menunggu verifikasi.');
        }

        if ($request->status_pembayaran == Order::STATUS_PEMBAYARAN_TERVERIFIKASI) {
            // Verifikasi pembayaran
            $order->verifyPayment($request->catatan_verifikasi);

            Log::info('Pembayaran diverifikasi', [
                'order_id'    => $order->id,
                'verified_by' => Auth::user()->id,
                'catatan'     => $request->catatan_verifikasi,
            ]);

            return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi. Pesanan diproses.');
        } else {
            // Tolak pembayaran
            $order->rejectPayment($request->catatan_verifikasi);

            Log::info('Pembayaran ditolak', [
                'order_id'    => $order->id,
                'rejected_by' => Auth::user()->id,
                'alasan'      => $request->catatan_verifikasi,
            ]);

            return redirect()->back()->with('success', 'Pembayaran ditolak. Pesanan dibatalkan.');
        }
    }

    /**
     * Cetak invoice
     */
    public function cetakInvoice($id)
    {
        $order = Order::with(['items.product', 'user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pelanggan.invoice', compact('order'));
    }
}

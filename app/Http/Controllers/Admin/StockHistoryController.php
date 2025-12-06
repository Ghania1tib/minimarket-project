<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockHistory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = StockHistory::with(['product', 'user'])
            ->orderBy('tanggal_perubahan', 'desc');

        // Apply filters
        if ($request->has('date') && $request->date) {
            $query->whereDate('tanggal_perubahan', $request->date);
        }

        if ($request->has('product') && $request->product) {
            $query->where('product_id', $request->product);
        }

        if ($request->has('type') && $request->type) {
            if ($request->type === 'in') {
                $query->where('jumlah_perubahan', '>', 0);
            } elseif ($request->type === 'out') {
                $query->where('jumlah_perubahan', '<', 0);
            }
        }

        $stockHistory = $query->paginate(20);
        $products = Product::active()->get(['id', 'nama', 'stok']);

        return view('admin.stock-history.index', compact('stockHistory', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah_perubahan' => 'required|integer',
            'order_id' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:255'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $product = Product::findOrFail($request->product_id);
                $stokSebelum = $product->stok;
                $stokSesudah = $stokSebelum + $request->jumlah_perubahan;

                // Update product stock
                $product->update(['stok' => $stokSesudah]);

                // Create stock history record
                StockHistory::create([
                    'product_id' => $request->product_id,
                    'user_id' => auth()->id(),
                    'order_id' => $request->order_id,
                    'jumlah_perubahan' => $request->jumlah_perubahan,
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokSesudah,
                    'keterangan' => $request->keterangan,
                    'tanggal_perubahan' => now(),
                ]);
            });

            return redirect()->route('admin.stock-history.index')
                ->with('success', 'Perubahan stok berhasil disimpan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $stockHistory = StockHistory::findOrFail($id);
            
            DB::transaction(function () use ($stockHistory) {
                // Revert product stock
                $product = Product::find($stockHistory->product_id);
                if ($product) {
                    $revertedStock = $product->stok - $stockHistory->jumlah_perubahan;
                    $product->update(['stok' => $revertedStock]);
                }
                
                $stockHistory->delete();
            });

            return redirect()->route('admin.stock-history.index')
                ->with('success', 'Riwayat stok berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
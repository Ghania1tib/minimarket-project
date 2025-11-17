<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        // GANTI: get() menjadi paginate()
        $promos = Promo::latest()->paginate(10); // 10 item per halaman

        return view('admin.promo.index', compact('promos'));
    }

    // Method lainnya tetap sama...
    public function create()
    {
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.promo.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'kode_promo' => 'required|unique:promos|max:50',
            'nama_promo' => 'required|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_promo' => 'required|in:diskon_persentase,diskon_nominal',
            'nilai_promo' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'kuota' => 'nullable|integer|min:1',
            'minimal_pembelian' => 'nullable|numeric|min:0',
            'maksimal_diskon' => 'nullable|numeric|min:0',
            'status' => 'required|in:1,0'
        ]);

        try {
            Promo::create([
                'kode_promo' => strtoupper($validated['kode_promo']),
                'nama_promo' => $validated['nama_promo'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'jenis_promo' => $validated['jenis_promo'],
                'nilai_promo' => $validated['nilai_promo'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_berakhir' => $validated['tanggal_berakhir'],
                'kuota' => $validated['kuota'] ?? null,
                'digunakan' => 0,
                'minimal_pembelian' => $validated['minimal_pembelian'] ?? 0,
                'maksimal_diskon' => $validated['maksimal_diskon'] ?? null,
                'status' => (bool)$validated['status']
            ]);

            return redirect()->route('promo.index')
                ->with('success', 'Promo berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Promo $promo)
    {
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.promo.show', compact('promo'));
    }

    public function edit(Promo $promo)
    {
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.promo.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'kode_promo' => 'required|max:50|unique:promos,kode_promo,' . $promo->id,
            'nama_promo' => 'required|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_promo' => 'required|in:diskon_persentase,diskon_nominal',
            'nilai_promo' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'kuota' => 'nullable|integer|min:1',
            'minimal_pembelian' => 'nullable|numeric|min:0',
            'maksimal_diskon' => 'nullable|numeric|min:0',
            'status' => 'required|in:1,0'
        ]);

        try {
            $promo->update([
                'kode_promo' => strtoupper($validated['kode_promo']),
                'nama_promo' => $validated['nama_promo'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'jenis_promo' => $validated['jenis_promo'],
                'nilai_promo' => $validated['nilai_promo'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_berakhir' => $validated['tanggal_berakhir'],
                'kuota' => $validated['kuota'] ?? null,
                'minimal_pembelian' => $validated['minimal_pembelian'] ?? 0,
                'maksimal_diskon' => $validated['maksimal_diskon'] ?? null,
                'status' => (bool)$validated['status']
            ]);

            return redirect()->route('promo.index')
                ->with('success', 'Promo berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Promo $promo)
    {
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        try {
            $promo->delete();
            return redirect()->route('promo.index')
                ->with('success', 'Promo berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('promo.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    public function index()
    {
        // Cek authorization
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $promos = Promo::latest()->get();
        return view('admin.promo.index', compact('promos'));
    }

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

        $request->validate([
            'kode_promo' => 'required|unique:promos|max:50',
            'nama_promo' => 'required|max:255',
            'deskripsi' => 'nullable',
            'jenis_promo' => 'required|in:diskon_persentase,diskon_nominal',
            'nilai_promo' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'kuota' => 'nullable|integer|min:1',
            'minimal_pembelian' => 'nullable|integer|min:0',
            'maksimal_diskon' => 'nullable|integer|min:0',
            'status' => 'boolean'
        ]);

        Promo::create([
            'kode_promo' => strtoupper($request->kode_promo),
            'nama_promo' => $request->nama_promo,
            'deskripsi' => $request->deskripsi,
            'jenis_promo' => $request->jenis_promo,
            'nilai_promo' => $request->nilai_promo,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'kuota' => $request->kuota,
            'minimal_pembelian' => $request->minimal_pembelian ?? 0,
            'maksimal_diskon' => $request->maksimal_diskon,
            'status' => $request->status ?? true
        ]);

        return redirect()->route('promo.index')
            ->with('success', 'Promo berhasil dibuat!');
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

        $request->validate([
            'kode_promo' => 'required|max:50|unique:promos,kode_promo,' . $promo->id,
            'nama_promo' => 'required|max:255',
            'deskripsi' => 'nullable',
            'jenis_promo' => 'required|in:diskon_persentase,diskon_nominal',
            'nilai_promo' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'kuota' => 'nullable|integer|min:1',
            'minimal_pembelian' => 'nullable|integer|min:0',
            'maksimal_diskon' => 'nullable|integer|min:0',
            'status' => 'boolean'
        ]);

        $promo->update([
            'kode_promo' => strtoupper($request->kode_promo),
            'nama_promo' => $request->nama_promo,
            'deskripsi' => $request->deskripsi,
            'jenis_promo' => $request->jenis_promo,
            'nilai_promo' => $request->nilai_promo,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'kuota' => $request->kuota,
            'minimal_pembelian' => $request->minimal_pembelian ?? 0,
            'maksimal_diskon' => $request->maksimal_diskon,
            'status' => $request->status ?? true
        ]);

        return redirect()->route('promo.index')
            ->with('success', 'Promo berhasil diupdate!');
    }

    public function destroy(Promo $promo)
    {
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $promo->delete();

        return redirect()->route('promo.index')
            ->with('success', 'Promo berhasil dihapus!');
    }
}

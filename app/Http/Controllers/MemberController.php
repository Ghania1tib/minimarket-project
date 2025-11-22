<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function __construct()
    {
        // Langkah 4: Middleware auth untuk proteksi halaman
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Langkah 4: Cek authentication dan role
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $members = Member::latest()->get();
        return view('member.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $kodeMember = Member::generateKodeMember();
        return view('member.create', compact('kodeMember'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'kode_member' => 'required|string|max:20|unique:members',
            'nama_lengkap' => 'required|string|max:100',
            'nomor_telepon' => 'required|string|max:20|unique:members',
            'tanggal_daftar' => 'required|date',
        ], [
            'kode_member.required' => 'Kode member wajib diisi.',
            'kode_member.unique' => 'Kode member sudah digunakan.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'nomor_telepon.unique' => 'Nomor telepon sudah terdaftar.',
            'tanggal_daftar.required' => 'Tanggal daftar wajib diisi.',
        ]);

        Member::create([
            'kode_member' => $request->kode_member,
            'nama_lengkap' => $request->nama_lengkap,
            'nomor_telepon' => $request->nomor_telepon,
            'tanggal_daftar' => $request->tanggal_daftar,
            'poin' => 0,
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $member = Member::findOrFail($id);
        return view('member.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $member = Member::findOrFail($id);
        return view('member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $member = Member::findOrFail($id);

        $request->validate([
            'kode_member' => 'required|string|max:20|unique:members,kode_member,' . $id,
            'nama_lengkap' => 'required|string|max:100',
            'nomor_telepon' => 'required|string|max:20|unique:members,nomor_telepon,' . $id,
            'tanggal_daftar' => 'required|date',
        ], [
            'kode_member.required' => 'Kode member wajib diisi.',
            'kode_member.unique' => 'Kode member sudah digunakan.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'nomor_telepon.unique' => 'Nomor telepon sudah terdaftar.',
            'tanggal_daftar.required' => 'Tanggal daftar wajib diisi.',
        ]);

        $member->update([
            'kode_member' => $request->kode_member,
            'nama_lengkap' => $request->nama_lengkap,
            'nomor_telepon' => $request->nomor_telepon,
            'tanggal_daftar' => $request->tanggal_daftar,
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $member = Member::findOrFail($id);

        // Cek jika member memiliki transaksi
        if ($member->orders()->count() > 0) {
            return redirect()->route('member.index')->with('error', 'Tidak dapat menghapus member yang memiliki riwayat transaksi!');
        }

        $member->delete();

        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus!');
    }

    /**
     * Search members - untuk fitur pencarian
     */
    public function search(Request $request)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $keyword = $request->input('keyword');

        if (!$keyword) {
            return redirect()->route('member.index');
        }

        $members = Member::where('nama_lengkap', 'LIKE', "%{$keyword}%")
                        ->orWhere('kode_member', 'LIKE', "%{$keyword}%")
                        ->orWhere('nomor_telepon', 'LIKE', "%{$keyword}%")
                        ->latest()
                        ->get();

        return view('member.index', compact('members', 'keyword'));
    }
}

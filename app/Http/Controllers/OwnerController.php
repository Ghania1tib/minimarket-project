<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function dashboard()
    {
        // Cek role
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk owner dan admin.');
        }

        // Logika dashboard owner
        return view('owner_dashboard');
    }

    public function users()
    {
        $user = Auth::user();
        if (!$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk owner dan admin.');
        }

        // Logika management users
        return view('owner.users');
    }
}

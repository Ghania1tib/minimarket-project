<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user->isKasir() && !$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk kasir, owner, dan admin.');
        }

        // Logika dashboard staff
        return view('staff_dashboard');
    }

    public function pos()
    {
        $user = Auth::user();
        if (!$user->isKasir() && !$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk kasir, owner, dan admin.');
        }

        // Logika POS
        return view('staff.pos');
    }
}

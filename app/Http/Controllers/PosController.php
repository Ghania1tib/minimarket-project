<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosController extends Controller
{
    // Dipanggil oleh route('pos.new')
    public function newTransaction()
    {
        return view('pos_new'); // Harus sesuai dengan nama file POS Anda
    }

    // Dipanggil oleh route('inventory.check')
    public function checkInventory()
    {
        return view('inventory_check'); // Harus sesuai dengan nama file Cek Stok
    }

    // Dipanggil oleh route('member.management')
    public function manageMembers()
    {
        return view('member_management'); // Harus sesuai dengan nama file Kelola Member
    }

    // Dipanggil oleh route('pos.return')
    public function processReturn()
    {
        return view('pos_return');
    }

    // Dipanggil oleh route('diskon.management')
    public function manageDiscounts()
    {
        return view('discount_management');
    }

    // Dipanggil oleh route('laporan.kasir')
    public function cashierReport()
    {
        return view('cashier_report');
    }
}

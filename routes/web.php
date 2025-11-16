<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Minimarket Project
|--------------------------------------------------------------------------
*/

// =======================================================================
// PUBLIC ROUTES (LANDING PAGE & AUTH)
// =======================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Statis
Route::controller(PageController::class)->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/terms', 'terms')->name('terms');
});

// Autentikasi
Route::controller(AuthController::class)->group(function () {
    Route::get('/signup', 'showSignupForm')->name('signup');
    Route::post('/signup', 'signup')->name('submit.signup');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('submit.login');
    Route::post('/logout', 'logout')->name('logout');
});

// =======================================================================
// OWNER/ADMIN ROUTES - Pengecekan role dilakukan di Controller
// =======================================================================
Route::middleware(['auth'])->group(function () {
    // Dashboard Owner & Admin
    Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Resource Routes untuk Owner/Admin
    Route::resource('kategori', KategoriController::class);
    Route::resource('user', UserController::class);
    Route::resource('produk', ProdukController::class);

    // Custom Routes
    Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');

    Route::resource('promo', PromoController::class);
});

// =======================================================================
// STAFF/KASIR ROUTES - Pengecekan role dilakukan di Controller
// =======================================================================
Route::middleware(['auth'])->group(function () {
    // Dashboard Staff
    Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('dashboard.staff');

    // POS Routes
    Route::prefix('pos')->controller(PosController::class)->group(function () {
        Route::get('/new', 'newTransaction')->name('pos.new');
        Route::post('/process', 'processTransaction')->name('pos.process');
        Route::get('/invoice/{id}', 'showInvoice')->name('pos.invoice');
        Route::get('/product/{id}', 'getProduct')->name('pos.product');
    });

    // Member Management
    Route::prefix('member')->controller(MemberController::class)->group(function () {
        Route::get('/search', 'search')->name('member.search');
        Route::post('/store', 'store')->name('member.store');
    });
    Route::resource('member', MemberController::class)->except(['store']);

    // Laporan dan Inventory untuk Staff
    Route::controller(PosController::class)->group(function () {
        Route::get('/inventory/check', 'checkInventory')->name('inventory.check');
        Route::get('/diskon/management', 'manageDiscounts')->name('diskon.management');
        Route::get('/laporan/kasir', 'cashierReport')->name('laporan.kasir');
    });
});

// =======================================================================
// PELANGGAN/CUSTOMER ROUTES - Pengecekan role dilakukan di Controller
// =======================================================================
Route::middleware(['auth'])->prefix('pelanggan')->controller(PelangganController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('pelanggan.dashboard');
    Route::get('/profil', 'profil')->name('pelanggan.profil');
    Route::post('/profil/update', 'updateProfil')->name('pelanggan.profil.update');
    Route::get('/riwayat', 'riwayatTransaksi')->name('pelanggan.riwayat');
    Route::get('/transaksi/{order}', 'detailTransaksi')->name('pelanggan.transaksi.detail');
});

// =======================================================================
// FALLBACK ROUTE UNTUK USER YANG SUDAH LOGIN
// =======================================================================
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->isOwner() || $user->isAdmin()) {
        return redirect()->route('owner.dashboard');
    } elseif ($user->isKasir()) {
        return redirect()->route('dashboard.staff');
    } elseif ($user->isCustomer()) {
        return redirect()->route('pelanggan.dashboard');
    }

    return redirect('/');
})->middleware('auth');

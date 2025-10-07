<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\MemberController;

// Halaman Utama
Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('kategori', KategoriController::class);
Route::resource('produk', ProdukController::class);
Route::resource('user', UserController::class);

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('submit.signup');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('submit.login');

Route::get('/staff/dashboard', function () {
    return view('staff_dashboard');
})->name('dashboard.staff');

Route::get('/pos/new', [PosController::class, 'newTransaction'])->name('pos.new');
Route::get('/inventory/check', [PosController::class, 'checkInventory'])->name('inventory.check');
Route::get('/member/management', [PosController::class, 'manageMembers'])->name('member.management');

Route::post('/member/store', [MemberController::class, 'store'])->name('member.store');

Route::get('/diskon/management', [PosController::class, 'manageDiscounts'])->name('diskon.management');

Route::get('/laporan/kasir', [PosController::class, 'cashierReport'])->name('laporan.kasir');

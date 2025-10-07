<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;


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


// Grup route khusus untuk pelanggan yang sudah login

Route::middleware(['auth'])->prefix('akun')->name('pelanggan.')->group(function () {

    // CUKUP BERI NAMA 'dashboard'
    // Laravel akan otomatis menggabungkannya menjadi 'pelanggan.dashboard'
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('dashboard');

    // Lakukan hal yang sama untuk route lainnya
    Route::get('/profil', [PelangganController::class, 'profil'])->name('profil');
    Route::post('/profil', [PelangganController::class, 'updateProfil'])->name('profil.update');
    Route::get('/transaksi', [PelangganController::class, 'riwayatTransaksi'])->name('riwayat');
    Route::get('/transaksi/{order}', [PelangganController::class, 'detailTransaksi'])->name('transaksi.detail');

// Route untuk menampilkan semua kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

// Route untuk hasil pencarian produk
Route::get('/produk/cari', [ProdukController::class, 'search'])->name('produk.search');
});



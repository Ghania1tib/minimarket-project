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
use App\Http\Controllers\PromoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\CheckoutController;
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
// PUBLIC PRODUCT & CATEGORY ROUTES (Dapat diakses tanpa login)
// =======================================================================
Route::controller(ProdukController::class)->group(function () {
    Route::get('/produk', 'index')->name('produk.index');
    Route::get('/produk/{id}', 'show')->name('produk.show');
    Route::get('/produk/search', 'search')->name('produk.search');
});

Route::controller(KategoriController::class)->group(function () {
    Route::get('/kategori', 'index')->name('kategori.index');
    Route::get('/kategori/{id}', 'show')->name('kategori.show');
});

// =======================================================================
// CART ROUTES (Dapat diakses oleh user yang sudah login)
// =======================================================================
Route::middleware(['auth'])->controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add/{productId}', 'add')->name('cart.add');
    Route::put('/cart/update/{cart}', 'update')->name('cart.update');
    Route::delete('/cart/remove/{cart}', 'remove')->name('cart.remove');
    Route::get('/cart/count', 'count')->name('cart.count');
    Route::post('/cart/checkout', 'checkout')->name('cart.checkout');
    Route::delete('/cart/clear', 'clear')->name('cart.clear');
    Route::get('/cart/data', 'getCartData')->name('cart.data');
});
Route::middleware(['auth'])->controller(CheckoutController::class)->group(function () {
    Route::get('/checkout', 'index')->name('checkout');
});

// =======================================================================
// PELANGGAN ROUTES
// =======================================================================
Route::middleware(['auth'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    // Dashboard & Profil
    Route::controller(PelangganController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profil', 'profil')->name('profil');
        Route::put('/profil/update', 'updateProfil')->name('profil.update');
    });

    // Keranjang - PERBAIKAN: Tambahkan route keranjang di dalam grup pelanggan
    Route::controller(CartController::class)->group(function () {
        Route::get('/keranjang', 'index')->name('keranjang');
    });

    // Pesanan
    Route::controller(PesananController::class)->group(function () {
        Route::get('/pesanan', 'index')->name('pesanan');
        Route::get('/pesanan/{id}', 'show')->name('pesanan.detail');
        Route::post('/pesanan/{id}/batalkan', 'batalkan')->name('pesanan.batalkan');
        Route::post('/pesanan/{id}/bayar', 'bayar')->name('pesanan.bayar');
        Route::get('/riwayat', 'riwayat')->name('riwayat'); // TAMBAHKAN ROUTE INI
    });
});

// =======================================================================
// OWNER/ADMIN ROUTES
// =======================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('kategori', KategoriController::class)->except(['index', 'show']);
    Route::resource('user', UserController::class);
    Route::resource('produk', ProdukController::class)->except(['index', 'show']);
    Route::resource('promo', PromoController::class);

    Route::get('/produk/search/admin', [ProdukController::class, 'searchAdmin'])->name('produk.search.admin');
});

// =======================================================================
// STAFF/KASIR ROUTES
// =======================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('dashboard.staff');

    Route::prefix('pos')->controller(PosController::class)->group(function () {
        Route::get('/new', 'newTransaction')->name('pos.new');
        Route::post('/process', 'processTransaction')->name('pos.process');
        Route::get('/invoice/{id}', 'showInvoice')->name('pos.invoice');
        Route::get('/product/{id}', 'getProduct')->name('pos.product');
        Route::get('/cart-items', 'getCartItems')->name('pos.cart-items');
        Route::post('/add-to-cart', 'addToCart')->name('pos.add-to-cart');
        Route::put('/update-cart/{id}', 'updateCart')->name('pos.update-cart');
        Route::delete('/remove-from-cart/{id}', 'removeFromCart')->name('pos.remove-from-cart');
        Route::post('/apply-discount', 'applyDiscount')->name('pos.apply-discount');
    });

    Route::resource('member', MemberController::class);
});

// =======================================================================
// FALLBACK ROUTE UNTUK USER YANG SUDAH LOGIN
// =======================================================================
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (($user->role === 'owner') || ($user->role === 'admin')) {
        return redirect()->route('owner.dashboard');
    } elseif ($user->role === 'kasir') {
        return redirect()->route('dashboard.staff');
    } elseif ($user->role === 'pelanggan') {
        return redirect()->route('pelanggan.dashboard');
    }

    return redirect('/');
})->name('dashboard')->middleware('auth');

// =======================================================================
// FALLBACK ROUTE UNTUK 404
// =======================================================================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

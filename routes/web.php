<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CashierReportController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PaymentVerificationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Minimarket Project (Optimized & Complete)
|--------------------------------------------------------------------------
*/

// =======================================================================
// 1. PUBLIC & AUTH ROUTES
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
// 2. PUBLIC PRODUCT & CATEGORY VIEWS (Unauthenticated & General)
// =======================================================================
Route::controller(ProdukController::class)->group(function () {
    Route::get('/produk', 'index')->name('produk.index');
    Route::get('/produk/create', 'store')->name('produk.create');
    Route::get('/produk/search', 'search')->name('produk.search');
    Route::get('/produk/{id}', 'show')->name('produk.show');
});

Route::controller(KategoriController::class)->group(function () {
    Route::get('/kategori', 'index')->name('kategori.index');
    Route::get('/kategori/create', 'store')->name('kategori.create');
    Route::get('/kategori/{id}', 'show')->name('kategori.show');
});

// =======================================================================
// 3. CUSTOMER ROUTES (AUTH REQUIRED)
// =======================================================================
Route::middleware(['auth'])->group(function () {

    // Keranjang & Checkout
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart.index');
        Route::post('/cart/add/{productId}', 'add')->name('cart.add');
        Route::put('/cart/update/{cart}', 'update')->name('cart.update');
        Route::delete('/cart/remove/{cart}', 'remove')->name('cart.remove');
        Route::get('/cart/count', 'count')->name('cart.count');
        Route::post('/cart/checkout', 'checkout')->name('cart.checkout');
        Route::delete('/cart/clear', 'clear')->name('cart.clear');
        Route::get('/cart/data', 'getCartData')->name('cart.data');
    });

    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/checkout', 'index')->name('checkout.index');
        Route::post('/checkout/process', 'checkout')->name('checkout.process');
        Route::post('/checkout/{orderId}/upload-payment', 'processPaymentUpload')->name('checkout.upload-payment');
        Route::get('/checkout/success/{orderId}', 'success')->name('checkout.success');
    });

    // Pelanggan Dashboard & Profil
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::controller(PelangganController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/profil', 'profil')->name('profil');
            Route::put('/profil/update', 'updateProfil')->name('profil.update');
        });

        // Pesanan Customer
        Route::controller(PesananController::class)->group(function () {
            Route::get('/pesanan', 'index')->name('pesanan');
            Route::get('/pesanan/{id}', 'show')->name('pesanan.detail');
            Route::post('/pesanan/{id}/batalkan', 'batalkan')->name('pesanan.batalkan');
            Route::post('/pesanan/{id}/bayar', 'bayar')->name('pesanan.bayar');
            Route::post('/pesanan/{id}/upload-bukti', 'uploadPaymentProof')->name('pesanan.upload-bukti');
            Route::get('/riwayat', 'riwayat')->name('riwayat');
        });

        // Kompatibilitas routes transaksi
        Route::get('/transaksi/{id}', [PesananController::class, 'show'])->name('transaksi.detail');
        Route::put('/transaksi/{id}/batalkan', [PesananController::class, 'batalkan'])->name('transaksi.batalkan');
        Route::post('/transaksi/{id}/bayar', [PesananController::class, 'bayar'])->name('transaksi.bayar');
    });
});

// =======================================================================
// 4. STAFF/KASIR ROUTES (AUTH REQUIRED)
// =======================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('dashboard.staff');

    // POS System
    Route::prefix('pos')->name('pos.')->controller(PosController::class)->group(function () {
        Route::get('/new', 'newTransaction')->name('new');
        Route::post('/process', 'processTransaction')->name('process');
        Route::get('/invoice/{id}', 'showInvoice')->name('invoice');
        Route::get('/product/{id}', 'getProduct')->name('product');
        Route::get('/cart-items', 'getCartItems')->name('cart-items');
        Route::post('/add-to-cart', 'addToCart')->name('add-to-cart');
        Route::put('/update-cart/{id}', 'updateCart')->name('update-cart');
        Route::delete('/remove-from-cart/{id}', 'removeFromCart')->name('remove-from-cart');
        Route::post('/apply-discount', 'applyDiscount')->name('apply-discount');
        Route::get('/member/search', 'searchMemberByKode')->name('member.search');
        Route::get('/member/search-by-phone', 'searchMemberByPhone')->name('member.search.phone');
        Route::get('/products/search', 'searchProducts')->name('products.search');
    });

    // Inventory Management
    Route::prefix('inventory')->group(function () {
        Route::get('/check', [PosController::class, 'checkInventory'])->name('inventory.check');
        Route::get('/search', [PosController::class, 'searchInventory'])->name('inventory.search');
        Route::get('/product/{id}', [PosController::class, 'getInventoryProductDetail'])->name('inventory.product.detail');
    });

    // Member Management
    Route::resource('member', MemberController::class);

    // Cashier Reports
    Route::prefix('cashier')->name('cashier.')->controller(CashierReportController::class)->group(function () {
        Route::get('/report', 'cashierReport')->name('report');
        Route::post('/close-shift', 'closeShift')->name('close-shift');
        Route::post('/start-shift', 'startShift')->name('start-shift');
        Route::get('/shift/{id}', 'getShiftDetail')->name('shift.detail');
        Route::get('/export', 'exportLaporan')->name('export');
    });
});

// =======================================================================
// 5. PAYMENT VERIFICATION & ORDER MANAGEMENT (ADMIN & KASIR)
// =======================================================================

Route::middleware(['auth'])->group(function () {
    Route::prefix('payment-verification')->name('payment.verification.')->group(function () {

        // Dashboard Verifikasi & Pesanan
        Route::get('/dashboard', [PaymentVerificationController::class, 'dashboard'])->name('dashboard');

        // Manajemen Pesanan (Admin & Kasir)
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [PaymentVerificationController::class, 'ordersIndex'])->name('index');
            Route::get('/{id}', [PaymentVerificationController::class, 'ordersShow'])->name('show');
            Route::post('/{id}/update-status', [PaymentVerificationController::class, 'ordersUpdateStatus'])->name('update-status');
            Route::post('/{id}/update-shipping', [PaymentVerificationController::class, 'ordersUpdateShipping'])->name('update-shipping');
        });

        // Verifikasi Pembayaran (Admin & Kasir)
        Route::get('/', [PaymentVerificationController::class, 'paymentVerificationIndex'])->name('index');
        Route::get('/{id}', [PaymentVerificationController::class, 'paymentVerificationShow'])->name('show');
        Route::post('/{id}/verify', [PaymentVerificationController::class, 'paymentVerify'])->name('verify');
        Route::post('/{id}/reject', [PaymentVerificationController::class, 'paymentReject'])->name('reject');
    });
});

// =======================================================================
// 6. ADMIN/OWNER MANAGEMENT ROUTES (AUTH REQUIRED)
// =======================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Product Management (Staff & Admin)
    Route::prefix('produk')->name('produk.')->controller(ProdukController::class)->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/search/admin', 'searchAdmin')->name('search.admin');
    });

    // Category Management (Staff & Admin)
    Route::resource('kategori', KategoriController::class)->except(['index', 'show']);

    // User Management (Admin Only)
    Route::resource('user', UserController::class);

    // Admin Reports & Analysis
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/sales-report', [AdminController::class, 'salesReport'])->name('sales.report');
        Route::get('/stock-history', [AdminController::class, 'stockHistory'])->name('stock.history');
        Route::get('/product-analysis', [AdminController::class, 'productAnalysis'])->name('product.analysis');
        Route::get('/export-data', [AdminController::class, 'exportData'])->name('export.data');

        // System Settings (Admin Only)
        Route::get('/settings', [AdminController::class, 'systemSettings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSystemSettings'])->name('settings.update');
    });
});

// =======================================================================
// 7. LARAVEL SOCIALITE ROUTES (GOOGLE AUTH)
// =======================================================================
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

// =======================================================================
// 8. FALLBACK & REDIRECTS
// =======================================================================
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->isOwner() || $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isKasir()) {
        return redirect()->route('dashboard.staff');
    } elseif ($user->isCustomer()) {
        return redirect()->route('pelanggan.dashboard');
    }

    return redirect('/');
})->name('dashboard')->middleware('auth');

// Route::fallback(function () {
//     return response()->view('errors.404', [], 404);
// });



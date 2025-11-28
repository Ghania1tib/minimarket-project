<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\StaffController; // Ini tidak digunakan tapi tetap dipertahankan
use App\Http\Controllers\UserController;
use App\Http\Controllers\CashierReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Minimarket Project (Optimized)
|--------------------------------------------------------------------------
| Pengaturan urutan prioritas (precedence) rute sangat penting.
| Rute yang lebih spesifik (/produk/create) harus diletakkan SEBELUM
| rute yang lebih umum (/produk/{id}).
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
// 2. STAFF/ADMIN PRODUCT MANAGEMENT ROUTES (Authenticated & Specific)
// =======================================================================
/* | PENTING: Rute-rute CRUD produk ini harus diutamakan (diletakkan di atas)
| rute publik /produk/{id} agar /produk/create tidak diinterpretasikan
| sebagai ID produk.
*/
Route::middleware(['auth'])->group(function () {

    Route::prefix('produk')->controller(ProdukController::class)->group(function () {
        // CRUD Produk (Priority High)
        Route::get('/create', 'create')->name('produk.create');
        Route::post('/', 'store')->name('produk.store');
        Route::get('/{id}/edit', 'edit')->name('produk.edit');
        Route::put('/{id}', 'update')->name('produk.update');
        Route::delete('/{id}', 'destroy')->name('produk.destroy');
        Route::get('/search/admin', 'searchAdmin')->name('produk.search.admin');
    });

    // CRUD Kategori (Diperlukan juga untuk form Produk/Create)
    Route::resource('kategori', KategoriController::class)->except(['index', 'show']);
});

// =======================================================================
// 3. PUBLIC PRODUCT & CATEGORY VIEWS (Unauthenticated & General)
// =======================================================================
Route::controller(ProdukController::class)->group(function () {
    Route::get('/produk', 'index')->name('produk.index');
    Route::get('/produk/search', 'search')->name('produk.search');
    // Rute paling umum diletakkan di akhir
    Route::get('/produk/{id}', 'show')->name('produk.show');
});

Route::controller(KategoriController::class)->group(function () {
    Route::get('/kategori', 'index')->name('kategori.index');
    Route::get('/kategori/{id}', 'show')->name('kategori.show');
});

// =======================================================================
// 4. E-COMMERCE / PELANGGAN ROUTES (AUTH REQUIRED)
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
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('pelanggan.pesanan.detail');

    // Pelanggan Dashboard, Profil, Pesanan
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::controller(PelangganController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/profil', 'profil')->name('profil');
            Route::put('/profil/update', 'updateProfil')->name('profil.update');
        });

        Route::controller(PesananController::class)->group(function () {
            Route::get('/pesanan', 'index')->name('pesanan');
            Route::get('/pesanan/{id}', 'show')->name('pesanan.detail');
            Route::post('/pesanan/{id}/batalkan', 'batalkan')->name('pesanan.batalkan');
            Route::post('/pesanan/{id}/bayar', 'bayar')->name('pesanan.bayar');
            Route::get('/riwayat', 'riwayat')->name('riwayat');
        });
    });
});

// =======================================================================
// 5. STAFF/KASIR POS & DASHBOARD ROUTES (AUTH REQUIRED)
// =======================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('dashboard.staff');

    // POS Routes
    Route::prefix('pos')->controller(PosController::class)->group(function () {
        Route::get('/new', 'newTransaction')->name('pos.new');
        Route::post('/process', [PosController::class, 'processTransaction'])->name('pos.process');
        Route::get('/invoice/{id}', 'showInvoice')->name('pos.invoice');
        Route::get('/product/{id}', 'getProduct')->name('pos.product');
        Route::get('/cart-items', 'getCartItems')->name('pos.cart-items');
        Route::post('/add-to-cart', 'addToCart')->name('pos.add-to-cart');
        Route::put('/update-cart/{id}', 'updateCart')->name('pos.update-cart');
        Route::delete('/remove-from-cart/{id}', 'removeFromCart')->name('pos.remove-from-cart');
        Route::post('/apply-discount', 'applyDiscount')->name('pos.apply-discount');
        Route::get('/member/search', 'searchMemberByKode')->name('pos.member.search');
        Route::get('/member/search-by-phone', 'searchMemberByPhone')->name('pos.member.search.phone');
        Route::get('/products/search', 'searchProducts')->name('pos.products.search');
    });

    // Route lainnya untuk staff
    Route::get('/inventory/search', [PosController::class, 'searchInventory'])->name('inventory.search');
    Route::get('/inventory/product/{id}', [PosController::class, 'getInventoryProductDetail'])->name('inventory.product.detail');
    Route::get('/inventory/check', [PosController::class, 'checkInventory'])->name('inventory.check');
    Route::resource('member', MemberController::class);

    // Routes untuk Laporan Kasir
    Route::middleware(['auth'])->group(function () {
        Route::get('/cashier/report', [CashierReportController::class, 'cashierReport'])->name('cashier.report');
        Route::post('/cashier/close-shift', [CashierReportController::class, 'closeShift'])->name('cashier.close-shift');
        Route::post('/cashier/start-shift', [CashierReportController::class, 'startShift'])->name('cashier.start-shift');
        Route::get('/cashier/shift/{id}', [CashierReportController::class, 'getShiftDetail'])->name('cashier.shift.detail');
        Route::get('/cashier/export', [CashierReportController::class, 'exportLaporan'])->name('cashier.export');
    });
});

// =======================================================================
// 6. OWNER/ADMIN MANAGEMENT ROUTES (AUTH REQUIRED)
// =======================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('user', UserController::class);
    Route::resource('promo', PromoController::class);
    Route::post('/promo/{promo}/toggle-status', [PromoController::class, 'toggleStatus'])->name('promo.toggle-status');

    // Tambahkan route untuk OwnerController jika diperlukan, namun saat ini
    // semua rute admin/owner diarahkan ke AdminController/UserController.
});

// =======================================================================
// 7. FALLBACK & REDIRECTS
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

Route::fallback(function () {
    // Pastikan Anda memiliki view 'errors.404'
    return response()->view('errors.404', [], 404);
});

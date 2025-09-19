<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMenuController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Registration routes
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/', [UserMenuController::class, 'latestMenus'])->name('beranda');

// <-- JANGAN LUPA IMPORT

// Route::get('/', function () {
//     // Nama 'Beranda' merujuk ke file Beranda.vue
//     return Inertia::render('Beranda');
// });

// Route::get('/reservasi', function () {
//     return view('pages.users.reservasi');
// })->name('reservasi');
Route::get('/contact-us', function () {
    return view('pages.users.kontak');
})->name('kontak');

Route::get('/about', function () {
    return view('pages.users.about_us');
})->name('about-us');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('menu')->name('menu.')->group(function () {
    Route::get('/', [App\Http\Controllers\UserMenuController::class, 'index'])->name('index');
    Route::get('/category/{categoryId}', [App\Http\Controllers\UserMenuController::class, 'category'])->name('category');
    Route::get('/detail/{id}', [App\Http\Controllers\UserMenuController::class, 'show'])->name('show');
    Route::get('/search', [App\Http\Controllers\UserMenuController::class, 'search'])->name('search');
    Route::get('/filter-price', [App\Http\Controllers\UserMenuController::class, 'filterByPrice'])->name('filter-price');
    Route::get('/get-items', [App\Http\Controllers\UserMenuController::class, 'getMenuItems'])->name('get-items');
});

Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [App\Http\Controllers\KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/add', [App\Http\Controllers\KeranjangController::class, 'addToCart'])->name('keranjang.add');
    Route::put('/keranjang/update/{kodeItem}', [App\Http\Controllers\KeranjangController::class, 'updateQuantity'])->name('keranjang.update');
    Route::delete('/keranjang/remove/{kodeItem}', [App\Http\Controllers\KeranjangController::class, 'removeItem'])->name('keranjang.remove');
    Route::delete('/keranjang/clear', [App\Http\Controllers\KeranjangController::class, 'clearCart'])->name('keranjang.clear');
    Route::post('/keranjang/increment/{kodeItem}', [App\Http\Controllers\KeranjangController::class, 'incrementQuantity'])->name('keranjang.increment');
    Route::post('/keranjang/decrement/{kodeItem}', [App\Http\Controllers\KeranjangController::class, 'decrementQuantity'])->name('keranjang.decrement');
    Route::get('/keranjang/count', [App\Http\Controllers\KeranjangController::class, 'getCartCount'])->name('keranjang.count');
    Route::get('/keranjang/total', [App\Http\Controllers\KeranjangController::class, 'getCartTotal'])->name('keranjang.total');

    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::post('/create', [TransaksiController::class, 'checkout'])->name('store');
        // Route::get('/{id}', [TransaksiController::class, 'userShow'])->name('show');
        Route::patch('/{id}/cancel', [TransaksiController::class, 'userCancel'])->name('cancel');
        Route::get('/{kode_transaksi}', [TransaksiController::class, 'userDetail'])->name('show');
        Route::post('/midtrans/webhook', [TransaksiController::class, 'handleWebhook'])->name('midtrans.webhook');
        Route::post('/update-status', [TransaksiController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Route::apiResource('reservasi', ReservasiController::class);

    Route::get('/reservasi', [ReservasiController::class, 'getAllMeja'])->name('reservasi.meja');

    // Rute untuk memproses form reservasi
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');

    Route::get('/reservasi/{kode_reservasi}', [ReservasiController::class, 'detail'])->name('reservasi.detail');

    Route::get('/reservasi-history', [ReservasiController::class, 'history'])->name('reservasi.history');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan.index');
    // Menu routes
    Route::resource('menu', MenuController::class);
    // Add these routes to your web.php file inside the admin group
    Route::resource('kategori', KategoriController::class);

    Route::resource('meja', App\Http\Controllers\MejaController::class);
    Route::resource('inventory', InventoryController::class)->except(['show', 'create', 'edit']);

    Route::patch('/meja/{id}/status', [MejaController::class, 'updateStatus'])
        ->name('meja.updateStatus');

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::patch('users/{id}/change-role', [UserController::class, 'changeRole'])->name('users.change-role');

    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'indexAdmin'])->name('index');
        Route::get('/stats', [TransaksiController::class, 'adminStats'])->name('stats');
        Route::get('/export', [TransaksiController::class, 'adminExport'])->name('export');
        Route::get('/create', [TransaksiController::class, 'adminCreate'])->name('create');
        Route::post('/', [TransaksiController::class, 'adminStore'])->name('store');
        Route::get('/{kode_transaksi}', [TransaksiController::class, 'adminShow'])->name('show');
        Route::get('/{kode_transaksi}/edit', [TransaksiController::class, 'adminEdit'])->name('edit');
        Route::put('/{kode_transaksi}', [TransaksiController::class, 'adminUpdate'])->name('update');
        Route::delete('/{kode_transaksi}', [TransaksiController::class, 'adminDestroy'])->name('destroy');
        Route::patch('/{id}/confirm', [TransaksiController::class, 'adminConfirm'])->name('confirm');
        Route::patch('/{id}/reject', [TransaksiController::class, 'adminReject'])->name('reject');
        Route::patch('/{id}/complete', [TransaksiController::class, 'adminComplete'])->name('complete');
        Route::patch('/{id}/update-status', [TransaksiController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::get('report', [TransaksiController::class, 'report'])->name('transaksi.report');
    Route::get('export', [TransaksiController::class, 'adminExport'])->name('transaksi.export');

    Route::prefix('reservasi')->name('reservasi.')->group(function () {
        Route::get('/', [ReservasiController::class, 'adminIndex'])->name('index');
        Route::get('/create', [ReservasiController::class, 'adminCreate'])->name('create');
        Route::post('/', [ReservasiController::class, 'adminStore'])->name('store');
        Route::get('/{kode_reservasi}', [ReservasiController::class, 'adminShow'])->name('show');
        Route::get('/{kode_reservasi}/edit', [ReservasiController::class, 'adminEdit'])->name('edit');
        Route::put('/{kode_reservasi}', [ReservasiController::class, 'adminUpdate'])->name('update');
        Route::delete('/{kode_reservasi}', [ReservasiController::class, 'adminDestroy'])->name('destroy');
    });
});
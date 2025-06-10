<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMenuController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Registration routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/', [UserMenuController::class, 'latestMenus'])->name('beranda');

Route::get('/reservasi', function () {
    return view('pages.users.reservasi');
})->name('reservasi');
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

    Route::prefix('user/transaksi')->name('user.transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'userIndex'])->name('index');
        Route::get('/create', [TransaksiController::class, 'userCreate'])->name('create');
        Route::post('/', [TransaksiController::class, 'userCheckoutStore'])->name('store');
        Route::get('/{id}', [TransaksiController::class, 'userShow'])->name('show');
        Route::patch('/{id}/cancel', [TransaksiController::class, 'userCancel'])->name('cancel');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('pages.admin.index');
    })->name('dashboard');

    // Menu routes
    Route::resource('menu', MenuController::class);
    // Add these routes to your web.php file inside the admin group
    Route::resource('kategori', App\Http\Controllers\KategoriProdukController::class);

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::patch('users/{id}/change-role', [UserController::class, 'changeRole'])->name('users.change-role');

    Route::prefix('admin/transaksi')->name('admin.transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'adminIndex'])->name('index');
        Route::get('/stats', [TransaksiController::class, 'adminStats'])->name('stats');
        Route::get('/export', [TransaksiController::class, 'adminExport'])->name('export');
        Route::get('/{id}', [TransaksiController::class, 'adminShow'])->name('show');
        Route::patch('/{id}/confirm', [TransaksiController::class, 'adminConfirm'])->name('confirm');
        Route::patch('/{id}/reject', [TransaksiController::class, 'adminReject'])->name('reject');
        Route::patch('/{id}/complete', [TransaksiController::class, 'adminComplete'])->name('complete');
    });
});

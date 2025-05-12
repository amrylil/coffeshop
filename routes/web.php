<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
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
});

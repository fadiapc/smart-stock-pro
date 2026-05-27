<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AuthController;

Route::get('/', fn () => redirect()->route('inventory.dashboard'));
Route::get('/app/inventory', [InventoryController::class, 'dashboard'])->name('inventory.dashboard');
Route::post('/inventory/sell', [InventoryController::class, 'recordSale'])->name('inventory.sell');
Route::get('/inventory/critical-stock', [InventoryController::class, 'criticalStock'])->name('inventory.critical');

// Rute untuk mengarahkan root url langsung ke login
Route::get('/', function () {
    return redirect('/login');
});

// Rute Autentikasi (Bisa diakses tanpa login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rute yang WAJIB Login (Dilindungi oleh middleware 'auth')
Route::middleware(['auth', 'log.activity'])->prefix('app')->group(function () {
    
    // Rute Dashboard & PDF
    Route::get('/inventory', [InventoryController::class, 'dashboard'])->name('inventory.dashboard');
    Route::get('/inventory/export-pdf', [InventoryController::class, 'exportPdf'])->name('inventory.pdf');
    
    // Rute Jual (Ajax)
    Route::post('/inventory/sell', [InventoryController::class, 'sell']);
    
    // Rute Tambah Pegawai
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Rute Logout
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::get('/server-stats', [App\Http\Controllers\InventoryController::class, 'serverStats'])->name('inventory.server-stats');

    Route::resource('/warehouses', App\Http\Controllers\WarehouseController::class);
    Route::resource('/products', App\Http\Controllers\ProductController::class);
    Route::resource('/users', App\Http\Controllers\UserController::class);
    Route::resource('/suppliers', App\Http\Controllers\SupplierController::class);
    Route::resource('/transactions', App\Http\Controllers\TransactionController::class);
});
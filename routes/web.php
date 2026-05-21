<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;

Route::get('/', fn () => redirect()->route('inventory.dashboard'));
Route::get('/admin/inventory', [InventoryController::class, 'dashboard'])->name('inventory.dashboard');
Route::post('/inventory/sell', [InventoryController::class, 'recordSale'])->name('inventory.sell');
Route::get('/inventory/critical-stock', [InventoryController::class, 'criticalStock'])->name('inventory.critical');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AdminSaleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Toko (Store Owner) Routes
Route::middleware(['auth', 'role:Toko'])->prefix('toko')->group(function () {
    Route::get('/dashboard', [TokoController::class, 'dashboard'])->name('toko.dashboard');
    Route::get('/store/create', [TokoController::class, 'createStore'])->name('toko.create_store');
    Route::post('/store', [TokoController::class, 'storeStore'])->name('toko.store_store');
    Route::get('/products', [TokoController::class, 'products'])->name('toko.products');
});

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/stores', [AdminController::class, 'stores'])->name('admin.stores');
    Route::get('/store/{id}', [AdminController::class, 'showStore'])->name('admin.show_store');
    Route::put('/store/{id}/status', [AdminController::class, 'updateStoreStatus'])->name('admin.update_store_status');
    Route::get('/users-without-store', [AdminController::class, 'usersWithoutStore'])->name('admin.users_without_store');
    // Route::post('/store/create-for-user', [AdminController::class, 'createStoreForUser'])->name('admin.create_store_for_user');
    Route::post('/store/create-for-user', [AdminController::class, 'createStoreForUser'])->name('admin.create_store_for_user');
});
// Admin Product Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});
// Toko Sales Routes
Route::middleware(['auth', 'role:Toko'])->prefix('toko')->group(function () {
    Route::get('/sales', [SaleController::class, 'index'])->name('toko.sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('toko.sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('toko.sales.store');
    Route::get('/sales/{id}', [SaleController::class, 'show'])->name('toko.sales.show');
    Route::get('/sales/{id}/pdf', [SaleController::class, 'generatePdf'])->name('toko.sales.pdf');
});
// Admin Sales Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    Route::get('/sales', [AdminSaleController::class, 'index'])->name('admin.sales.index');
    Route::get('/sales/{id}', [AdminSaleController::class, 'show'])->name('admin.sales.show');
    Route::put('/sales/{id}/status', [AdminSaleController::class, 'updateStatus'])->name('admin.sales.update_status');
});
// In routes/web.php
Route::get('/admin/sales/{id}/pdf', [AdminSaleController::class, 'generatePdf'])->name('admin.sales.pdf');
Route::get('/offline', function () {
    return view('offline');
});

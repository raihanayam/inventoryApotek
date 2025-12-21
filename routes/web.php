<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatKeluarController;
use App\Http\Controllers\ObatMasukController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\LaporanMasukController;
use App\Http\Controllers\LaporanKeluarController;
use App\Http\Controllers\LaporanStokController;
use App\Http\Middleware\IsLogin;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'loginView']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(IsLogin::class)->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/products/export-pdf', [ProductController::class, 'exportPDF'])->name('products.exportPDF');
    Route::get('/masuk/export-pdf', [ObatMasukController::class, 'exportPDF'])->name('obatMasuk.exportPDF');
    Route::get('/keluar/export-pdf', [ObatKeluarController::class, 'exportPDF'])->name('obatKeluar.exportPDF');

    Route::get('/laporan/masuk/export-pdf', [LaporanMasukController::class, 'exportPDF'])->name('laporanMasuk.exportPDF');
    Route::get('/laporan/keluar/export-pdf', [LaporanKeluarController::class, 'exportPDF'])->name('laporanKeluar.exportPDF');
    Route::get('/laporan/stok/export-pdf', [LaporanStokController::class, 'exportPDF'])->name('laporanStok.exportPDF');

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/create', [CategoryController::class, 'create']);
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('/categories/store', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'delete']);

    Route::get('/satuans', [SatuanController::class, 'index']);
    Route::get('/satuans/create', [SatuanController::class, 'create']);
    Route::get('/satuans/edit/{id}', [SatuanController::class, 'edit']);
    Route::post('/satuans/store', [SatuanController::class, 'store']);
    Route::put('/satuans/{id}', [SatuanController::class, 'update']);
    Route::delete('/satuans/{id}', [SatuanController::class, 'delete']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products/store', [ProductController::class, 'store']);
    Route::get('/products/edit/{product}', [ProductController::class, 'edit']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::get('/products/{product}', [ProductController::class, 'show']);

    Route::get('/masuk', [ObatMasukController::class, 'index']);
    Route::get('/masuk/create', [ObatMasukController::class, 'create']);
    Route::post('/masuk', [ObatMasukController::class, 'store']);
    Route::get('/masuk/{id}', [ObatMasukController::class, 'show']);
    Route::delete('/masuk/{id}', [ObatMasukController::class, 'delete']);

    Route::get('/keluar', [ObatKeluarController::class, 'index']);
    Route::get('/keluar/create', [ObatKeluarController::class, 'create']);
    Route::post('/keluar', [ObatKeluarController::class, 'store']);
    Route::get('/keluar/{id}', [ObatKeluarController::class, 'show']);
    Route::delete('/keluar/{id}', [ObatKeluarController::class, 'delete']);

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::get('/user/edit/{id}', [UserController::class, 'edit']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'delete']);

    Route::get('/laporanMasuk', [LaporanMasukController::class, 'index']);
    Route::get('/laporanKeluar', [LaporanKeluarController::class, 'index']);
    Route::get('/laporanStok', [LaporanStokController::class, 'index']);
});
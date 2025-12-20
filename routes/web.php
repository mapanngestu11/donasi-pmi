<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LaporanDonasiController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\KategoriBeritaController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanKeuanganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/berita', [FrontendController::class, 'berita'])->name('frontend.berita');
Route::get('/berita/{slug}', [FrontendController::class, 'beritaDetail'])->name('frontend.berita.detail');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('frontend.gallery');
Route::get('/laporan/export', [FrontendController::class, 'exportLaporan'])->name('frontend.laporan.export');

// Donasi Routes
Route::prefix('donasi')->name('donasi.')->group(function () {
    Route::get('/create', [DonasiController::class, 'create'])->name('create');
    Route::post('/store', [DonasiController::class, 'store'])->name('store');
    Route::get('/status/{orderId}', [DonasiController::class, 'status'])->name('status');
    Route::post('/notification', [DonasiController::class, 'notification'])->name('notification');
    Route::get('/finish', [DonasiController::class, 'finish'])->name('finish');
    Route::get('/unfinish', [DonasiController::class, 'unfinish'])->name('unfinish');
    Route::get('/error', [DonasiController::class, 'error'])->name('error');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login Routes
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
    
    // Authenticated Admin Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        
        // Donasi Routes
        Route::prefix('donasi')->name('donasi.')->group(function () {
            Route::get('/laporan', [LaporanDonasiController::class, 'index'])->name('laporan');
            Route::get('/laporan/export', [LaporanDonasiController::class, 'export'])->name('laporan.export');
            Route::get('/laporan/{id}', [LaporanDonasiController::class, 'show'])->name('laporan.show');
            Route::delete('/laporan/{id}', [LaporanDonasiController::class, 'destroy'])->name('laporan.destroy');
            
            // Pengeluaran Routes
            Route::prefix('pengeluaran')->name('pengeluaran.')->group(function () {
                Route::get('/', [PengeluaranController::class, 'index'])->name('index');
                Route::get('/create', [PengeluaranController::class, 'create'])->name('create');
                Route::post('/store', [PengeluaranController::class, 'store'])->name('store');
                Route::get('/show/{id}', [PengeluaranController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [PengeluaranController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [PengeluaranController::class, 'update'])->name('update');
                Route::post('/delete/{id}', [PengeluaranController::class, 'destroy'])->name('destroy');
            });
        });
        
        // Berita Routes
        Route::prefix('berita')->name('berita.')->group(function () {
            Route::get('/', [BeritaController::class, 'index'])->name('index');
            Route::get('/create', [BeritaController::class, 'create'])->name('create');
            Route::post('/store', [BeritaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [BeritaController::class, 'update'])->name('update');
            Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('destroy');
            
            // Kategori Routes
            Route::prefix('kategori')->name('kategori.')->group(function () {
                Route::get('/', [KategoriBeritaController::class, 'index'])->name('index');
                Route::post('/store', [KategoriBeritaController::class, 'store'])->name('store');
                Route::get('/{id}', [KategoriBeritaController::class, 'show'])->name('show');
                Route::put('/{id}', [KategoriBeritaController::class, 'update'])->name('update');
                Route::delete('/{id}', [KategoriBeritaController::class, 'destroy'])->name('destroy');
            });
        });
        
        // Gallery Routes
        Route::prefix('gallery')->name('gallery.')->group(function () {
            Route::get('/', [GalleryController::class, 'index'])->name('index');
            Route::get('/create', [GalleryController::class, 'create'])->name('create');
            Route::post('/store', [GalleryController::class, 'store'])->name('store');
            Route::get('/show/{id}', [GalleryController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [GalleryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [GalleryController::class, 'update'])->name('update');
            Route::post('/delete/{id}', [GalleryController::class, 'destroy'])->name('destroy');
        });
        
        // Laporan Keuangan Routes
        Route::prefix('laporan-keuangan')->name('laporan-keuangan.')->group(function () {
            Route::get('/', [LaporanKeuanganController::class, 'index'])->name('index');
            Route::get('/export/excel', [LaporanKeuanganController::class, 'exportExcel'])->name('export.excel');
            Route::get('/export/pdf', [LaporanKeuanganController::class, 'exportPdf'])->name('export.pdf');
        });
        
        // User Routes
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });
    });
});

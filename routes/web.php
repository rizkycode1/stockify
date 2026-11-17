
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\RiwayatAktivitasController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [RegisterController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'register'])
        ->name('register.process');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('kategori', KategoriController::class);

    Route::resource('supplier', SupplierController::class);

    Route::resource('barang', BarangController::class);

    Route::resource('barang-masuk', BarangMasukController::class)
        ->parameters(['barang-masuk' => 'barangMasuk']);

    Route::resource('barang-keluar', BarangKeluarController::class)
        ->only(['index', 'create', 'store'])
        ->parameters(['barang-keluar' => 'barangKeluar']);

    Route::get('/riwayat-aktivitas', [RiwayatAktivitasController::class, 'index'])
        ->name('aktivitas.index');

    Route::get('/laporan-inventaris', [LaporanController::class, 'index'])
        ->name('laporan.index');
});

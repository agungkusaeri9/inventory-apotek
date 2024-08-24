<?php

use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\BarangKeluarController;
use App\Http\Controllers\Admin\BarangMasukController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JenisController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/login', 301);

Auth::routes();

// admin
Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('users', UserController::class);
    // jenis
    Route::resource('jenis', JenisController::class)->except('show');

    // satuan
    Route::resource('satuan', SatuanController::class)->except('show');

    // barang
    Route::resource('barang', BarangController::class)->except('show');
    Route::get('barang/get-by-id-json', [BarangController::class, 'getByIdJson'])->name('barang.getByIdJson');

    // barang-masuk
    Route::get('barang-masuk/laporan', [BarangMasukController::class, 'laporan'])->name('barang-masuk.laporan');
    Route::post('barang-masuk/laporan/print', [BarangMasukController::class, 'print'])->name('barang-masuk.print');
    Route::resource('barang-masuk', BarangMasukController::class)->except('show');

    // barang-keluar
    Route::get('barang-keluar/laporan', [BarangKeluarController::class, 'laporan'])->name('barang-keluar.laporan');
    Route::post('barang-keluar/laporan/print', [BarangKeluarController::class, 'print'])->name('barang-keluar.print');
    Route::resource('barang-keluar', BarangKeluarController::class);

    // transaksi
    Route::get('transaksi/laporan', [TransaksiController::class, 'laporan'])->name('transaksi.laporan');
    Route::post('transaksi/laporan/print', [TransaksiController::class, 'print'])->name('transaksi.print');
    Route::resource('transaksi', TransaksiController::class)->except('edit', 'destroy');
});

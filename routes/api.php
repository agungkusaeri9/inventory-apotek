<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BarangController;
use App\Http\Controllers\API\BarangKeluarController;
use App\Http\Controllers\API\BarangMasukController;
use App\Http\Controllers\API\JenisController;
use App\Http\Controllers\API\SatuanController;
use App\Http\Controllers\API\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('update-password', [AuthController::class, 'updatePassword']);
});

Route::name('api.')->middleware('auth.jwt')->group(function () {
    Route::apiResource('/barang', BarangController::class);
    Route::apiResource('barang-masuk', BarangMasukController::class);
    Route::apiResource('barang-keluar', BarangKeluarController::class);
    Route::get('jenis', [JenisController::class, 'index']);
    Route::get('satuan', [SatuanController::class, 'index']);
    Route::get('supplier', [SupplierController::class, 'index']);
});

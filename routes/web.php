<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Pages\{ BarangController, GajiController, UsersController, HomeController, KasirController};
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LoginController::class, 'v_login'])->name('login');

Route::post('/login', [LoginController::class, 'check']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/change/password', [UsersController::class, 'updatepw']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::put('/v/edit/profile/{id}', [UsersController::class, 'update'])->name('update/profile');
Route::get('/d/karyawan', [UsersController::class, 'index'])->name('d/karyawan');
Route::get('/d/karyawan/{id}', [UsersController::class, 'show'])->name('d/karyawan');
Route::post('/d/karyawan/add', [UsersController::class, 'store'])->name('add/karyawan');
Route::put('/d/karyawan/ban/{id}', [UsersController::class, 'ban'])->name('ban/karyawan');
Route::put('/d/karyawan/aktif/{id}', [UsersController::class, 'aktif'])->name('aktif/karyawan');
Route::delete('/d/karyawan/{id}', [UsersController::class, 'destroy'])->name('delete/karyawan');

Route::get('/d/barang', [BarangController::class, 'index']);
Route::get('/d/barang/print', [BarangController::class, 'print']);
Route::get('/d/barang/export', [BarangController::class, 'export']);
Route::get('/d/barang/jum', [BarangController::class, 'tableJum']);
Route::get('/d/barang/{id}', [BarangController::class, 'show']);
Route::post('/d/barang', [BarangController::class, 'store']);
Route::put('/d/barang/{id}', [BarangController::class, 'update']);
Route::delete('/d/barang/{id}', [BarangController::class, 'destroy']);

Route::get('/d/gaji/karyawan', [GajiController::class, 'index']);
Route::get('/d/gaji/karyawan/check', [GajiController::class, 'gajiKrywm']);
Route::get('/d/gaji/karyawan/print/{id}', [GajiController::class, 'printGaji']);
Route::get('/d/gaji/karyawan/{id}', [GajiController::class, 'show']);
Route::post('/d/gaji/karyawan', [GajiController::class, 'store']);
Route::put('/d/gaji/karyawan/{id}', [GajiController::class, 'update']);
Route::delete('/d/gaji/karyawan/{id}', [GajiController::class, 'destroy']);

Route::get('/d/transaksi', [KasirController::class, 'index']);
Route::post('/d/transaksi', [KasirController::class, 'store']);
Route::put('/d/transaksi/tambah/{id}', [KasirController::class, 'tambah']);
Route::put('/d/transaksi/kurang/{id}', [KasirController::class, 'kurang']);

Route::post('/d/kategori/json', [BarangController::class, 'kategoriJson']);

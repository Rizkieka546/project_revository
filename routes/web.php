<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangBelumDikembalikanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ReferensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SUController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function(){
    return view('auth.login');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth')->get('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    //     Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('dashboard.admin');

    Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('dashboard.admin');
    Route::get('/laporan-barang', [LaporanController::class, 'laporanBarang'])->name('laporan.barang');
    Route::get('/laporan-pengembalian', [LaporanController::class, 'laporanPengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan-status-barang', [LaporanController::class, 'laporanStatusBarang'])->name('laporan.status');

    Route::prefix('jenis-barang')->group(function () {
        Route::get('/', [ReferensiController::class, 'jnsindex'])->name('jenis_barang.index');
        Route::get('/create', [ReferensiController::class, 'jnscreate'])->name('jenis_barang.create');
        Route::post('/store', [ReferensiController::class, 'jnsstore'])->name('jenis_barang.store');
        Route::get('/edit/{id}', [ReferensiController::class, 'jnsedit'])->name('jenis_barang.edit');
        Route::put('/update/{id}', [ReferensiController::class, 'jnsupdate'])->name('jenis_barang.update');
        Route::delete('/delete/{id}', [ReferensiController::class, 'jnsdestroy'])->name('jenis_barang.destroy');
    });

    Route::prefix('siswa')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('siswa.index');
        Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('/', [SiswaController::class, 'store'])->name('siswa.store');
    });

    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user', [UserController::class, 'store'])->name('user.store');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/operator', [OperatorController::class, 'index'])->name('dashboard.operator');

    // Barang
    Route::prefix('barang')->name('barang.')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::get('/create', [BarangController::class, 'create'])->name('create');
        Route::post('/store', [BarangController::class, 'store'])->name('store');
        Route::get('/edit/{br_kode}', [BarangController::class, 'edit'])->name('edit');
        Route::put('/update/{br_kode}', [BarangController::class, 'update'])->name('update');
        Route::delete('/destroy/{br_kode}', [BarangController::class, 'destroy'])->name('destroy');
    });

    // Peminjaman
    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/create', [PeminjamanController::class, 'create'])->name('create');
        Route::post('/store', [PeminjamanController::class, 'store'])->name('store');
    });

    // Pengembalian
    Route::prefix('pengembalian')->name('pengembalian.')->group(function () {
        Route::get('/', [PengembalianController::class, 'index'])->name('index');
        Route::put('/{pb_id}/{br_kode}', [PengembalianController::class, 'kembalikan'])->name('kembalikan');
    });


    // Barang Belum Dikembalikan
    Route::get('/barang-belum-kembali', [BarangBelumDikembalikanController::class, 'index'])->name('belumkembali.index');
});




Route::middleware(['auth'])->prefix('super_user')->group(function () {
    Route::get('/dashboard', [SUController::class, 'index'])->name('su.dashboard.super.user');

    Route::get('/barang', [SUController::class, 'indexB'])->name('su.barang.index');
    Route::get('/barang/create', [SUController::class, 'createB'])->name('su.barang.create');
    Route::post('/barang/store', [SUController::class, 'storeB'])->name('su.barang.store');
    Route::get('/barang/edit/{br_kode}', [SUController::class, 'editB'])->name('su.barang.edit');
    Route::put('/barang/update/{br_kode}', [SUController::class, 'updateB'])->name('su.barang.update');
    Route::delete('/barang/destroy/{br_kode}', [SUController::class, 'destroyB'])->name('su.barang.destroy');

    Route::get('/peminjaman', [SUController::class, 'indexPM'])->name('su.peminjaman.index');
    Route::get('/peminjaman/create', [SUController::class, 'createPM'])->name('su.peminjaman.create');
    Route::post('/peminjaman/store', [SUController::class, 'storePM'])->name('su.peminjaman.store');
    Route::get('/peminjaman/edit/{pb_id}', [SUController::class, 'editPM'])->name('su.peminjaman.edit');
    Route::put('/peminjaman/update/{pb_id}', [SUController::class, 'updatePM'])->name('su.peminjaman.update');
    Route::delete('/peminjaman/destroy/{pb_id}', [SUController::class, 'destroyPM'])->name('su.peminjaman.destroy');

    Route::get('/pengembalian', [SUController::class, 'indexPengembalian'])->name('su.pengembalian.index');
    Route::put('/pengembalian/{pb_id}/{br_kode}', [SUController::class, 'kembalikan'])->name('su.pengembalian.kembalikan');

    Route::get('/barang-belum-kembali', [SUController::class, 'indexBBK'])->name('su.barangbelumkembali.index');

    Route::get('/laporan-barang', [SUController::class, 'laporanBarang'])->name('su.laporan.barang');
    Route::get('/laporan-pengembalian', [SUController::class, 'laporanPengembalian'])->name('su.laporan.pengembalian');
    Route::get('/laporan-status-barang', [SUController::class, 'laporanStatusBarang'])->name('su.laporan.status');

    Route::prefix('jenis-barang')->group(function () {
        Route::get('/', [SUController::class, 'jnsindex'])->name('su.jenis_barang.index');
        Route::get('/create', [SUController::class, 'jnscreate'])->name('su.jenis_barang.create');
        Route::post('/store', [SUController::class, 'jnsstore'])->name('su.jenis_barang.store');
        Route::get('/edit/{id}', [SUController::class, 'jnsedit'])->name('su.jenis_barang.edit');
        Route::put('/update/{id}', [SUController::class, 'jnsupdate'])->name('su.jenis_barang.update');
        Route::delete('/delete/{id}', [SUController::class, 'jnsdestroy'])->name('su.jenis_barang.destroy');
    });

    Route::prefix('siswa')->group(function () {
        Route::get('/', [SUController::class, 'indexS'])->name('su.siswa.index');
        Route::get('/create', [SUController::class, 'createS'])->name('su.siswa.create');
        Route::post('/', [SUController::class, 'storeS'])->name('su.siswa.store');
    });

    Route::get('user', [SUController::class, 'userindex'])->name('su.user.index');
    Route::get('user/create', [SUController::class, 'usercreate'])->name('su.user.create');
    Route::post('user', [SUController::class, 'userstore'])->name('su.user.store');
    Route::get('user/{user}/edit', [SUController::class, 'useredit'])->name('su.user.edit');
    Route::put('user/{user}', [SUController::class, 'userupdate'])->name('su.user.update');
    Route::delete('user/{user}', [SUController::class, 'userdestroy'])->name('su.user.destroy');
});

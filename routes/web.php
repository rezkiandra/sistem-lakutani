<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\UsahaTaniController;
use Illuminate\Support\Facades\Route;

Route::controller(GuestController::class)->group(function () {
    Route::get('/', 'index')->name('beranda');
    Route::get('/informasi', 'informasi')->name('informasi');
    Route::get('/layanan', 'layanan')->name('layanan');
    Route::get('/cuaca', 'cuaca')->name('cuaca');
});

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'signIn')->name('signIn');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'signUp')->name('signUp');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/pengaturan', [AuthController::class, 'edit'])->name('profile.edit');
    Route::put('/pengaturan', [AuthController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware('can:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/dashboard', 'index')->name('dashboard'); // admin.dashboard
                Route::get('/users', 'users')->name('users');         // admin.users
                Route::get('/produksis', 'produksis')->name('produksis'); // admin.produksis
                Route::get('/keuangans', 'keuangans')->name('keuangans'); // admin.keuangans
                Route::get('/kelayakans', 'kelayakans')->name('kelayakans'); // admin.kelayakans
                Route::get('/laporan-keuangan', 'laporanKeuangan')->name('laporan-keuangan');
                Route::get('/cetak-laporan-keuangan', 'cetakLaporanKeuangan')->name('cetak-laporan-keuangan');

                Route::get('/hasil-analisis/{produksi}', 'hasilAnalisis')->name('hasilAnalisis');
                Route::get('/hasil-analisis/{produksi}/cetak', 'cetakHasilAnalisis')->name('cetakHasilAnalisis');

                Route::get('/uji-kelayakan/{produksi}', 'ujiKelayakan')->name('ujiKelayakan');
                Route::get('/uji-kelayakan/{produksi}/cetak', 'cetakUjiKelayakan')->name('cetakUjiKelayakan');

                Route::get('/users/create', 'createUser')->name('createUser');
                Route::post('/users', 'storeUser')->name('storeUser');
                Route::get('/users/{user}/edit', 'editUser')->name('editUser');
                Route::put('/users/{user}', 'updateUser')->name('updateUser');
                Route::delete('/users/{user}', 'destroyUser')->name('destroyUser');

                Route::delete('/produksis/{produksi}', 'destroyProduksi')->name('destroyProduksi');
                Route::delete('/kelayakans/{kelayakan}', 'destroyKelayakan')->name('destroyKelayakan');
            });
        });

    Route::middleware('can:petani')
        ->prefix('petani')
        ->name('petani.')
        ->group(function () {
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/dashboard', 'index')->name('dashboard'); // petani.dashboard
            });

            Route::controller(UsahaTaniController::class)->group(function () {
                Route::get('/riwayat', 'index')->name('riwayat');

                Route::get('/produksi', 'index')->name('produksi');
                Route::get('/produksi/create', 'createProduksi')->name('createProduksi');
                Route::post('/produksi', 'storeProduksi')->name('storeProduksi');
                Route::get('/produksi/{produksi}', 'showProduksi')->name('showProduksi');
                Route::get('/produksi/{produksi}/edit', 'editProduksi')->name('editProduksi');
                Route::put('/produksi/{produksi}', 'updateProduksi')->name('updateProduksi');
                Route::delete('/produksi/{produksi}', 'destroyProduksi')->name('destroyProduksi');

                Route::get('/produksi/{produksi}/pendapatan/create', 'createPendapatan')->name('createPendapatan');
                Route::post('/pendapatan/{produksi}', 'storePendapatan')->name('storePendapatan');
                Route::get('/pendapatan/{pendapatan}', 'showPendapatan')->name('showPendapatan');
                Route::get('/pendapatan/{pendapatan}/edit', 'editPendapatan')->name('editPendapatan');
                Route::put('/pendapatan/{pendapatan}', 'updatePendapatan')->name('updatePendapatan');
                Route::delete('/pendapatan/{pendapatan}', 'destroyPendapatan')->name('destroyPendapatan');

                Route::get('/pendapatan/{pendapatan}/laba-rugi/create', 'createLabaRugi')->name('createLabaRugi');
                Route::post('/laba-rugi/{pendapatan}', 'storeLabaRugi')->name('storeLabaRugi');
                Route::get('/laba-rugi/{labaRugi}', 'showLabaRugi')->name('showLabaRugi');
                Route::get('/laba-rugi/{labaRugi}/edit', 'editLabaRugi')->name('editLabaRugi');
                Route::put('/laba-rugi/{labaRugi}', 'updateLabaRugi')->name('updateLabaRugi');
                Route::delete('/laba-rugi/{labaRugi}', 'destroyLabaRugi')->name('destroyLabaRugi');

                Route::get('/hasil-analisis/{produksi}', 'hasilAnalisis')->name('hasilAnalisis');
                Route::get('/hasil-analisis/{produksi}/cetak', 'cetakHasilAnalisis')->name('cetakHasilAnalisis');

                Route::get('/uji-kelayakan/{produksi}', 'ujiKelayakan')->name('ujiKelayakan');
                Route::get('/uji-kelayakan/{produksi}/cetak', 'cetakUjiKelayakan')->name('cetakUjiKelayakan');
            });

            Route::controller(KeuanganController::class)->group(function () {
                Route::get('/keuangan', 'index')->name('catatKeuangan');
                Route::get('/keuangan/create', 'create')->name('createKeuangan');
                Route::post('/keuangan', 'store')->name('storeKeuangan');
                Route::get('/keuangan/{keuangan}/edit', 'edit')->name('editKeuangan');
                Route::put('/keuangan/{keuangan}', 'update')->name('updateKeuangan');
                Route::delete('/keuangan/{keuangan}', 'destroy')->name('destroyKeuangan');
                Route::get('/keuangan/laporan', 'laporan')->name('laporanKeuangan');
                Route::get('/keuangan/export', 'export')->name('exportKeuangan');
            });
        });
});

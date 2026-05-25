<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\UsahaTaniController;
use Illuminate\Support\Facades\Route;

Route::controller(GuestController::class)->group(function () {
    Route::get('/', 'index')->name('beranda');
    Route::get('/informasi', 'informasi')->name('informasi');
    Route::get('/layanan', 'layanan')->name('layanan');
    Route::get('/icare', 'icare')->name('icare');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'signIn')->name('signIn');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'signUp')->name('signUp');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});

Route::prefix('admin')->group(function () {
    Route::controller(UsahaTaniController::class)->group(function () {
        Route::get('/produksi/create', 'createProduksi')->name('createProduksi');
        Route::post('/produksi', 'storeProduksi')->name('storeProduksi');
        
        Route::get('/produksi/{produksi}/pendapatan/create', 'createPendapatan')->name('createPendapatan');
        Route::post('/pendapatan/{produksi}', 'storePendapatan')->name('storePendapatan');

        Route::get('/pendapatan/{pendapatan}/laba-rugi/create', 'createLabaRugi')->name('createLabaRugi');
        Route::post('/laba-rugi/{pendapatan}', 'storeLabaRugi')->name('storeLabaRugi');
    });
});
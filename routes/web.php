<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\LabaController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\RugiController;
use App\Http\Controllers\WeatherController;
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

Route::controller(WeatherController::class)->group(function () {
    Route::get('/weather', 'index')->name('weather');
});


Route::prefix('admin')->group(function () {
    Route::resource('produksi', ProduksiController::class);;
    Route::resource('pendapatan', PendapatanController::class);;
    Route::resource('laba', LabaController::class);;
    Route::resource('rugi', RugiController::class);;
    Route::resource('analisis', AnalisisController::class);;
});

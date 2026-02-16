<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, GuestController};

Route::controller(GuestController::class)->group(function () {
    Route::get('/', 'index')->name('home');
		Route::get('/about', 'about')->name('about');
		Route::get('/layanan', 'layanan')->name('layanan');
});

Route::controller(AuthController::class)->group(function () {
		Route::get('/login', 'login')->name('login');
		Route::post('/login', 'signIn')->name('signIn');
		Route::get('/register', 'register')->name('register');
		Route::post('/register', 'signUp')->name('signUp');
		Route::post('/logout', 'logout')->name('logout');
});
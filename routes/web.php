<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google_redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google_callback');

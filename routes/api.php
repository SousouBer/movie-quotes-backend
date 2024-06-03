<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\QuoteController;

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google_callback');
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google_redirect');

Route::get('/user', [UserController::class, 'show'])->name('user.show')->middleware('auth:sanctum');

Route::middleware('guest')->group(function () {
	Route::post('/register', [AuthController::class, 'register'])->name('register');
	Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('verified');
	Route::post('/forgot-password', [PasswordController::class, 'forgotPassword'])->name('password.forgot');
	Route::post('/resend-email-verification/{email}', [EmailController::class, 'resendEmailVerification'])->name('email.resend_verification');
	Route::post('/reset-password/{email}/{token}', [PasswordController::class, 'resetPassword'])->name('password.reset');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/email-verify/{id}/{hash}', [EmailController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');

Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth:sanctum');

Route::controller(MovieController::class)->prefix('movies')->group(function () {
	Route::get('/', 'index')->name('movies.index');
	Route::get('/{movie}', 'show')->name('movies.show');
	Route::post('/', 'store')->name('movies.store');
	Route::patch('/{movie}', 'update')->name('movies.update');
	Route::delete('/{movie}', 'destroy')->name('movies.destroy');
});

Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');

Route::controller(QuoteController::class)->prefix('quotes')->group(function () {
	Route::get('/', 'index')->name('quotes.index');
	Route::get('/{quote}', 'show')->name('quotes.show');
	Route::post('/', 'store')->name('quotes.store');
	Route::patch('/{quote}', 'update')->name('quotes.update');
	Route::delete('/{quote}', 'destroy')->name('quotes.destroy');
});

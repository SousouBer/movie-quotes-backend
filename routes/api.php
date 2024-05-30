<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MovieController;

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

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

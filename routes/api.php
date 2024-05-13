<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
	return $request->user();
})->middleware('auth:sanctum');

Route::middleware('guest')->group(function () {
	Route::post('/register', [AuthController::class, 'register'])->name('register');
	Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('verified');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

Route::get('/email-verify/{id}/{hash}', [EmailController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');

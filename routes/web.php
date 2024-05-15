<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

Route::get('/', function () {
	return view('welcome');
});

Route::get('/auth/google/redirect', function () {
	return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function (Request $request) {
	$googleUser = Socialite::driver('google')->user();

	$existingUser = User::whereFirst('google_id', $googleUser->id);

	$googleUser = User::updateOrCreate([
		'google_id' => $googleUser->id,
	], [
		'username'                 => $googleUser->name,
		'email'                    => $googleUser->email,
		'password'                 => Str::password(10),
		'email_verified_at'        => now(),
	]);

	Auth::login($googleUser);

	// I think I will change this response here.
	return redirect(config('app.frontend_url') . '/landing');
});

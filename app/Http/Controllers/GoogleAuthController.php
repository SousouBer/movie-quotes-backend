<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
	public function redirect(Request $request): RedirectResponse
	{
		return Socialite::driver('google')->redirect();
	}

	public function callback(Request $request): RedirectResponse
	{
		$googleUser = Socialite::driver('google')->user();

		$existingUser = User::where('google_id', $googleUser->id)->first();

		if ($existingUser) {
			// If user already exists, update only email.
			$existingUser->update([
				'email'             => $googleUser->email,
			]);
			Auth::login($existingUser);
		} else {
			$googleUser = User::updateOrCreate([
				'google_id' => $googleUser->id,
			], [
				'avatar'                   => $googleUser->getAvatar(),
				'username'                 => $googleUser->name,
				'email'                    => $googleUser->email,
				'password'                 => Str::password(10),
				'email_verified_at'        => now(),
			]);

			Auth::login($googleUser);
		}

		return redirect(config('app.frontend_url') . '/landing');
	}
}

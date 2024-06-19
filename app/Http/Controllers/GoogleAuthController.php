<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
	public function redirect(Request $request): JsonResponse
	{
		$redirectUrl = Socialite::driver('google')->redirect()->getTargetUrl();
		return response()->json(['redirectUrl' => $redirectUrl], 200);
	}

	public function callback(): JsonResponse
	{
		$googleUser = Socialite::driver('google')->user();

		$accountExists = User::where('email', $googleUser->email)->first();

		if ($accountExists && !$accountExists->google_id) {
			return response()->json(['message' => 'User already has an account with this email'], 403);
		}

		$googleUser = User::updateOrCreate([
			'google_id' => $googleUser->id,
		], [
			'avatar'                   => $googleUser->getAvatar(),
			'username'                 => $googleUser->name,
			'email'                    => $googleUser->email,
			'email_verified_at'        => now(),
		]);

		Auth::login($googleUser);
		session()->regenerate();

		return response()->json(['message' => 'User successfully logged in'], 200);
	}
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
	public function redirect(Request $request): string
	{
		return Socialite::driver('google')->redirect()->getTargetUrl();
	}

	public function callback(Request $request): JsonResponse
	{
		$googleUser = Socialite::driver('google')->user();

		$googleUser = User::updateOrCreate([
			'google_id' => $googleUser->id,
		], [
			'avatar'                   => $googleUser->getAvatar(),
			'username'                 => $googleUser->name,
			'email'                    => $googleUser->email,
			'email_verified_at'        => now(),
		]);

		Auth::login($googleUser);

		return response()->json(['message' => 'User successfully logged in'], 200);
	}
}

<?php

namespace App\Http\Controllers;

use App\Actions\EmailVerificationUrl;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Jobs\SendEmailVerificationNotification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function register(RegistrationRequest $request): JsonResponse
	{
		$credentials = $request->validated();

		$user = User::create($credentials);

		$verificationUrl = EmailVerificationUrl::handle($user);

		SendEmailVerificationNotification::dispatch($user, $verificationUrl);

		return response()->json(['message' => 'User has been registered successfully'], 201);
	}

	public function login(LoginRequest $request): JsonResponse
	{
		$credentials = $request->validated();

		$field = filter_var($credentials['username_or_email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		$remember = $credentials['remember'] ?? false;

		if (Auth::attempt([$field => $credentials['username_or_email'], 'password' => $credentials['password']], $remember)) {
			$request->session()->regenerate();

			return response()->json(['message' => 'Your have successfully logged in.'], 200);
		}
		return response()->json(['username_or_email' => 'Provided credentials are not valid. Please, try again.'], 404);
	}

	public function logout(Request $request): JsonResponse
	{
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return response()->json(['message' => 'Your have successfully logged out.'], 200);
	}
}

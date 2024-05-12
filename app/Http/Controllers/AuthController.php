<?php

namespace App\Http\Controllers;

use App\Actions\EmailVerificationUrl;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
	public function register(RegistrationRequest $request): JsonResponse
	{
		$credentials = $request->validated();

		$user = User::create($credentials);

		$verificationUrl = EmailVerificationUrl::handle($user);

		$user->notify(new EmailVerificationNotification($verificationUrl));

		return response()->json(['message' => 'User has been registered successfully'], 201);
	}
}

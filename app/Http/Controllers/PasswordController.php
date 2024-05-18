<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Jobs\SendPasswordResetNotification;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
	public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
	{
		$email = $request->validated();

		$user = User::where('email', $email)->first();

		if (!$user) {
			return response()->json(['email' => 'User with provided email does not exist'], 404);
		}

		// $status = Password::sendResetLink(
		// 	$email
		// );

		SendPasswordResetNotification::dispatch($email);

		return response()->json(['message' => 'Password reset email successfully sent.'], 200);
	}

	public function resetPassword(PasswordResetRequest $request, string $email, string $token): JsonResponse
	{
		$password = $request->validated();

		$user = User::whereFirst('email', $email);

		$user->forceFill([
			'password' => Hash::make($password['password']),
		])->setRememberToken(Str::random(60));

		$user->save();

		event(new PasswordReset($user));

		return response()->json(['message' => 'Your password has been successfully reset.', 200]);
	}
}

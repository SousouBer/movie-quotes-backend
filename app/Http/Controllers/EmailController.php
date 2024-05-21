<?php

namespace App\Http\Controllers;

use App\Actions\EmailVerificationUrl;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailController extends Controller
{
	public function verifyEmail(Request $request, int $id, string $hash): JsonResponse
	{
		$user = User::findOrFail($id);

		if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
			return response()->json(['message' => 'Verification hash is invalid'], 400);
		}

		if ($user->hasVerifiedEmail()) {
			return response()->json(['message' => 'Email has already been verified.'], 422);
		}

		$user->markEmailAsVerified();

		event(new Verified($user));

		return response()->json(['message' => 'You have successfully verified your email', 200]);
	}

	public function resendEmailVerification(Request $request, string $email): JsonResponse
	{
		$user = User::where('email', $email)->first();

		if ($user->hasVerifiedEmail()) {
			return response()->json(['message' => 'Your email is already verified. You can log in'], 200);
		}

		$verificationUrl = EmailVerificationUrl::handle($user);

		$user->notify(new EmailVerificationNotification($verificationUrl));

		return response()->json(['message' => 'You have successfully resent an email verification link'], 200);
	}
}

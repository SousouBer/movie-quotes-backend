<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}

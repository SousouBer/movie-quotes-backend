<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
	public function update(UpdateProfileRequest $request): JsonResponse
	{
		$fields = $request->validated();

		$user = Auth::user();

		// WIll add changing the avatar with frontend.

		if ($request->filled('username')) {
			$user->username = $fields['username'];
		}

		if ($request->filled('password')) {
			$user->password = Hash::make($fields['password']);
		}

		$user->save();

		return response()->json(['message' => 'User profile was successfully changed', 201]);
	}
}

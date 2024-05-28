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

		if ($request->file('avatar')) {
			$user->avatar = '/storage/' . $request->file('avatar')->store('avatars', 'public');
		}

		if ($request->filled('username')) {
			$user->username = $fields['username'];
		}

		if ($request->filled('password')) {
			$user->password = Hash::make($fields['password']);
		}

		$user->save();

		return response()->json(['message' => 'User details have been updated successfully!'], 201);
	}
}

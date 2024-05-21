<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
	public function update(UpdateProfileRequest $request): JsonResponse
	{
		return response()->json(['message' => 'User profile was successfully changed', 201]);
	}
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function show(Request $request): UserResource
	{
		return UserResource::make($request->user());
	}
}

<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
	public function handle(Request $request, Closure $next): Response
	{
		$credential = $request->input('username_or_email');

		$field = filter_var($credential, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		$user = User::where($field, $credential)->first();

		if ($user && !$user->hasVerifiedEmail()) {
			return response()->json(['username_or_email' => __('validation.unverified_email')], 409);
		}

		return $next($request);
	}
}

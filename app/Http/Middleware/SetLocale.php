<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
	public function handle(Request $request, Closure $next): Response
	{
		$locale = $request->cookie('locale', 'en');

		App::setLocale($locale);
		Session::put('locale', $locale);

		return $next($request);
	}
}

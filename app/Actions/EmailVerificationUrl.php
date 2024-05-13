<?php

namespace App\Actions;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class EmailVerificationUrl
{
	public static function handle(User $user): string
	{
		$expiration = Carbon::now()->addMinutes(120);

		return URL::temporarySignedRoute(
			'verification.verify',
			$expiration,
			[
				'id'         => $user->getKey(),
				'hash'       => sha1($user->email),
			]
		);
	}
}

<?php

use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

test('Password reset link is successfully sent', function () {
	Notification::fake();

	$user = User::factory()->create();

	$userEmail = [
		'email' => $user->email,
	];

	$headers = ['Referer' => 'http://127.0.0.1:5173'];

	$response = $this->withHeaders($headers)->post(route('password.forgot'), $userEmail);

	$response->assertStatus(200)->assertJson(['message' => 'Password reset email successfully sent.']);

	Notification::assertSentTo($user, PasswordResetNotification::class);
});

test('User can successfully reset the password', function () {
	Notification::fake();

	$user = User::factory()->create([
		'password' => bcrypt('currentpassword'),
	]);

	$userEmail = [
		'email' => $user->email,
	];

	$headers = ['Referer' => 'http://127.0.0.1:5173'];

	$response = $this->withHeaders($headers)->post(route('password.forgot'), $userEmail);

	$response->assertStatus(200)->assertJson(['message' => 'Password reset email successfully sent.']);

	$resetPasswordUrl = '';
	Notification::assertSentTo(
		$user,
		PasswordResetNotification::class,
		function ($notification) use ($user, &$resetPasswordUrl) {
			$resetPasswordUrl = $notification->toMail($user)->viewData['resetPasswordUrl'];

			return true;
		}
	);

	// Extract the token from the URL to send with the email for resetting password.
	$queryParams = [];
	parse_str(parse_url($resetPasswordUrl, PHP_URL_QUERY), $queryParams);
	$token = $queryParams['token'];

	$newPassword = 'newpassword';

	$resetPasswordData = [
		'password'              => $newPassword,
		'password_confirmation' => $newPassword,
	];

	$resetPasswordRoute = route('password.reset', ['email' => $user->email, 'token' => $token]);

	$response = $this->withHeaders($headers)->post($resetPasswordRoute, $resetPasswordData);

	$response->assertStatus(200);

	$user->refresh();

	$this->assertTrue(Hash::check($newPassword, $user->password));
});

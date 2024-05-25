<?php

use App\Models\User;
use App\Notifications\PasswordResetNotification;
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

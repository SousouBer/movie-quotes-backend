<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

test('Google redirecting URL is successfully generated', function () {
	$response = $this->get(route('auth.google_redirect'));

	$response->assertStatus(200);

	$responseData = $response->json();

	expect($responseData)->toHaveKey('redirectUrl');

	$redirectUrlStartsWith = 'https://accounts.google.com/o/oauth2/';
	expect(str_starts_with($responseData['redirectUrl'], $redirectUrlStartsWith))->toBeTrue();
});

test('User can successfully log in with correct email and password', function () {
	$userPassword = Str::random(8);

	$user = User::factory()->create([
		'password' => bcrypt($userPassword),
	]);

	$credentials = [
		'username_or_email' => $user->email,
		'password'          => $userPassword,
	];

	$response = $this->post(route('login'), $credentials);

	$response->assertStatus(200);

	$this->assertTrue(Auth::check());
});

test('User can successfully log in with correct username and password', function () {
	$userPassword = Str::random(8);

	$user = User::factory()->create([
		'password' => bcrypt($userPassword),
	]);

	$credentials = [
		'username_or_email' => $user->username,
		'password'          => $userPassword,
	];

	$response = $this->post(route('login'), $credentials);

	$response->assertStatus(200);

	$this->assertTrue(Auth::check());
});

test('User can not log in with invalid credentials', function () {
	$userPassword = Str::random(8);
	$wrongPassword = Str::random(8);

	$user = User::factory()->create([
		'password' => bcrypt($userPassword),
	]);

	$credentials = [
		'username_or_email' => $user->email,
		'password'          => $wrongPassword,
	];

	$response = $this->post(route('login'), $credentials);

	$response->assertStatus(404);

	$this->assertNotTrue(Auth::check());
});

test('User can not log in without password', function () {
	$user = User::factory()->create();

	$credentials = [
		'username_or_email' => $user->email,
	];

	$response = $this->post(route('login'), $credentials);

	$response->assertSessionHasErrors(
		[
			'password',
		]
	);

	$response->assertSessionDoesntHaveErrors(
		[
			'username_or_email',
		]
	);

	$response->assertStatus(302);

	$this->assertNotTrue(Auth::check());
});

test('User can not log in without email or username', function () {
	$randomPassword = Str::random(8);

	$user = User::factory()->create([
		'password' => bcrypt($randomPassword),
	]);
	$user = User::factory()->create();

	$credentials = [
		'password' => $user->password,
	];

	$response = $this->post(route('login'), $credentials);

	$response->assertSessionHasErrors(
		[
			'username_or_email',
		]
	);

	$response->assertSessionDoesntHaveErrors(
		[
			'password',
		]
	);

	$response->assertStatus(302);

	$this->assertNotTrue(Auth::check());
});

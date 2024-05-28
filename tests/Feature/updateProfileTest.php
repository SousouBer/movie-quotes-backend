<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

test('User can successfully update the username', function () {
	$user = User::factory()->create();

	$exampleUsername = strtolower(Str::random(8));

	$this->actingAs($user);

	$response = $this->post(route('profile.update', ['username' => $exampleUsername]));

	$response->assertStatus(201);

	$this->assertEquals($user->username, $exampleUsername);
});

test('User can not update the username if it contains uppercase characters', function () {
	$user = User::factory()->create();

	$exampleUsername = strtoUpper(Str::random(8));

	$this->actingAs($user);

	$response = $this->post(route('profile.update', ['username' => $exampleUsername]));

	$response->assertStatus(302);

	$response->assertSessionHasErrors(
		[
			'username',
		]
	);

	$this->assertNotEquals($user->username, $exampleUsername);
});

test('User can not update the username if it contains less than 3 characters', function () {
	$user = User::factory()->create();

	$exampleUsername = strtolower(Str::random(2));

	$this->actingAs($user);

	$response = $this->post(route('profile.update', ['username' => $exampleUsername]));

	$response->assertStatus(302);

	$response->assertSessionHasErrors(
		[
			'username' => 'The username field must be at least 3 characters.',
		]
	);

	$this->assertNotEquals($user->username, $exampleUsername);
});

test('User can not update the username if it contains more than 15 characters', function () {
	$user = User::factory()->create();

	$exampleUsername = strtolower(Str::random(16));

	$this->actingAs($user);

	$response = $this->post(route('profile.update', ['username' => $exampleUsername]));

	$response->assertStatus(302);

	$response->assertSessionHasErrors(
		[
			'username' => 'The username field must not be greater than 15 characters.',
		]
	);

	$this->assertNotEquals($user->username, $exampleUsername);
});

test('User can not update the username if it already exists', function () {
	$authenticatedUser = User::factory()->create();

	$exampleUsername = strtolower(Str::random(10));

	$userSecond = User::factory()->create([
		'username' => $exampleUsername,
	]);

	$this->actingAs($authenticatedUser);

	$response = $this->post(route('profile.update', ['username' => $exampleUsername]));

	$response->assertStatus(302);

	$response->assertSessionHasErrors([
		'username' => 'The username has already been taken.',
	]);

	$this->assertNotEquals($authenticatedUser->username, $exampleUsername);
});

test('User successfully update the password', function () {
	$user = User::factory()->create();

	$newPassword = strtolower(Str::random(10));

	$this->actingAs($user);

	$newPasswordCredentials = [
		'password'              => $newPassword,
		'password_confirmation' => $newPassword,
	];

	$response = $this->post(route('profile.update', $newPasswordCredentials));

	$response->assertStatus(201);

	$response->assertSessionDoesntHaveErrors(
		[
			'password',
			'password_confirmation',
		]
	);

	$this->assertTrue(Hash::check($newPassword, $user->password));
});

test('User can not update the password if new password and password confirmation do not match', function () {
	$user = User::factory()->create();

	$newPassword = strtolower(Str::random(10));
	$passwordConfirmation = strtolower(Str::random(10));

	$this->actingAs($user);

	$newPasswordCredentials = [
		'password'              => $newPassword,
		'password_confirmation' => $passwordConfirmation,
	];

	$response = $this->post(route('profile.update', $newPasswordCredentials));

	$response->assertStatus(302);

	$response->assertSessionHasErrors(
		[
			'password' => 'The password field confirmation does not match.',
		]
	);

	$this->assertFalse(Hash::check($newPassword, $user->password));
});

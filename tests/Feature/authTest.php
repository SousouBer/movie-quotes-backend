<?php

use Laravel\Socialite\Contracts\User as SocialiteUser;

test('Google redirecting URL is successfully generated', function () {
	$response = $this->get(route('auth.google_redirect'));

	$response->assertStatus(200);

	$responseData = $response->json();

	expect($responseData)->toHaveKey('redirectUrl');

	$redirectUrlStartsWith = 'https://accounts.google.com/o/oauth2/';
	expect(str_starts_with($responseData['redirectUrl'], $redirectUrlStartsWith))->toBeTrue();
});

test('Google user successfully sends the request to callback and is registered and then authenticated', function () {
	$socialiteUser = Mockery::mock(SocialiteUser::class);
});

// $socialiteUser = Mockery::mock(User::class);

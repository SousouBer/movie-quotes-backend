<?php

test('Google redirecting URL is successfully generated', function () {
	$response = $this->get(route('auth.google_redirect'));

	$response->assertStatus(200);

	$responseData = $response->json();

	expect($responseData)->toHaveKey('redirectUrl');

	$redirectUrlStartsWith = 'https://accounts.google.com/o/oauth2/';
	expect(str_starts_with($responseData['redirectUrl'], $redirectUrlStartsWith))->toBeTrue();
});

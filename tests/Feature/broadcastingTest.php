<?php

use App\Events\userNotification;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

test('Comment broadcasting is successfully dispatched', function () {
	Event::fake();

	$user = User::factory()->create();
	$quote = Quote::inRandomOrder()->firstOrFail();

	// Add a comment in order to trigger the event.
	$commentData = [
		'quote_id' => $quote->id,
		'comment'  => Str::random(rand(1, 10)),
	];

	$this->actingAs($user);

	$response = $this->post(route('comments.store'), $commentData);

	$response->assertStatus(200);

	$response->assertSessionDoesntHaveErrors(
		[
			'user_id',
			'quote_id',
			'comment',
		]
	);

	$this->assertDatabaseHas('comments', [
		'user_id'  => $user->id,
		'quote_id' => $quote->id,
		'comment'  => $commentData['comment'],
	]);

	Event::assertDispatched(userNotification::class, function ($e) use ($user, $quote) {
		$notification = $e->notification;

		return $notification->quote_id === $quote->id
				&& $notification->receiver_id === $quote->user_id
				&& $notification->sender_id === $user->id
				&& $notification->comment_received === true;
	});

	$response->assertSessionDoesntHaveErrors();
});

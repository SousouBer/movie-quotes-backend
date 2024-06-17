<?php

use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

test('New quote is successfully added', function () {
	$user = User::factory()->create();
	$movie = Movie::inRandomOrder()->firstOrFail();

	$this->actingAs($user);

	$picture = UploadedFile::fake()->image('quotePicture.png');

	$quoteData = [
		'user_id'  => $user->id,
		'movie_id' => $movie->id,
		'quote'    => [
			'en' => 'Quote English',
			'ka' => 'ციტატა ქართულად',
		],
		'picture' => $picture,
	];

	$response = $this->post(route('quotes.store'), $quoteData);

	$response->assertStatus(201)->assertJson(['message' => 'Quote added successfully']);

	$response->assertSessionDoesntHaveErrors(
		[
			'quote.en',
			'quote.ka',
			'picture',
		]
	);

	$this->assertDatabaseHas('quotes', [
		'quote->en' => 'Quote English',
		'quote->ka' => 'ციტატა ქართულად',
	]);
});

test('New quote can not be added if no picture is provided', function () {
	$user = User::factory()->create();
	$movie = Movie::inRandomOrder()->firstOrFail();

	$this->actingAs($user);

	$quoteData = [
		'user_id'  => $user->id,
		'movie_id' => $movie->id,
		'quote'    => [
			'en' => 'Quote English Test',
			'ka' => 'ციტატა ქართულად სატესტო',
		],
	];

	$response = $this->post(route('quotes.store'), $quoteData);

	$response->assertStatus(302);

	$response->assertSessionDoesntHaveErrors(
		[
			'quote.en',
			'quote.ka',
		]
	);

	$response->assertSessionHasErrors(
		[
			'picture',
		]
	);

	$this->assertDatabaseMissing('quotes', [
		'quote->en' => $quoteData['quote']['en'],
		'quote->ka' => $quoteData['quote']['ka'],
	]);
});

test('Quote can be successfully updated', function () {
	$user = User::factory()->create();
	$quote = Quote::inRandomOrder()->firstOrFail();

	$this->actingAs($user);

	$newPicture = UploadedFile::fake()->image('newQuotePicture.png');

	$editedQuoteData = [
		'quote'    => [
			'en' => 'Quote English not edited',
			'ka' => 'ციტატა ქართულად შეუცვლელი',
		],
		'picture' => $newPicture,
	];

	$response = $this->patch(route('quotes.update', ['quote' => $quote->id]), $editedQuoteData);

	$response->assertStatus(201)->assertJson(['message' => 'Quote updated successfully']);

	$response->assertSessionDoesntHaveErrors(
		[
			'quote.en',
			'quote.ka',
			'picture',
		]
	);

	$this->assertEquals(Quote::findOrFail($quote->id)->quote, $editedQuoteData['quote']['en']);
});

test('Quote can be successfully deleted', function () {
	$user = User::factory()->create();
	$quote = Quote::inRandomOrder()->firstOrFail();

	$this->actingAs($user);

	$response = $this->delete(route('quotes.update', ['quote' => $quote->id]));

	$response->assertStatus(200)->assertJson(['message' => 'Quote deleted successfully']);

	$response->assertSessionDoesntHaveErrors(
		[
			'quote.en',
			'quote.ka',
			'picture',
		]
	);

	$this->assertDatabaseMissing('quotes', ['id' => $quote->id]);
});

test('User can successfully comment on a quote', function () {
	$user = User::factory()->create();
	$quote = Quote::inRandomOrder()->firstOrFail();

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
});

test('User can successfully like a quote', function () {
	$user = User::factory()->create();
	$quote = Quote::inRandomOrder()->firstOrFail();

	$this->actingAs($user);

	$response = $this->post(route('quotes.like'), ['quote_id' => $quote->id]);

	$response->assertStatus(200);

	$response->assertSessionDoesntHaveErrors(
		[
			'user_id',
			'quote_id',
			'is_liked',
		]
	);

	$this->assertDatabaseHas('likes', [
		'user_id'  => $user->id,
		'quote_id' => $quote->id,
		'is_liked' => true,
	]);
});

test('User can successfully unlike a quote', function () {
	$user = User::factory()->create();
	$quote = Quote::inRandomOrder()->firstOrFail();

	$this->actingAs($user);

	$response = $this->post(route('quotes.like'), ['quote_id' => $quote->id]);

	$response->assertStatus(200);

	$response->assertSessionDoesntHaveErrors(
		[
			'user_id',
			'quote_id',
			'is_liked',
		]
	);

	$this->assertDatabaseHas('likes', [
		'user_id'  => $user->id,
		'quote_id' => $quote->id,
		'is_liked' => true,
	]);

	// Unlike a quote here.
	$response = $this->post(route('quotes.like'), ['quote_id' => $quote->id]);

	$response->assertSessionDoesntHaveErrors(
		[
			'user_id',
			'quote_id',
			'is_liked',
		]
	);

	$this->assertDatabaseMissing('likes', [
		'user_id'  => $user->id,
		'quote_id' => $quote->id,
	]);
});

test('Quote can be successfully searched using # symbol', function () {
	// Set locale to English.
	$this->app->setLocale('en');

	$user = User::factory()->create();
	$quote = Quote::inRandomOrder()->firstOrFail();

	$englishQuote = $quote->quote;

	$quoteLength = mt_rand(1, 10);

	$this->disableCookieEncryption();

	// Get a random str length to imiate search.
	$searchValue = '#' . mb_substr($englishQuote, 0, $quoteLength);

	$this->actingAs($user);

	$response = $this->withCookie('locale', 'en')->get(route('quotes.index', ['filter[search]' => $searchValue]));

	$response->assertStatus(200);

	$quotes = $response->json('data');

	foreach ($quotes as $quote) {
		$searchValueWithoutSign = mb_substr($searchValue, 1);

		$valueInQuote = stripos($quote['quote'], $searchValueWithoutSign);

		$this->assertNotFalse($valueInQuote);
	}
});

test('Georgian quote can be successfully searched using # symbol', function () {
	// Set locale to English.
	$this->app->setLocale('ka');

	$user = User::factory()->create();
	$quote = Quote::inRandomOrder()->firstOrFail();

	$georgianQuote = $quote->quote;

	$quoteLength = mt_rand(1, 10);

	$this->disableCookieEncryption();

	$searchValue = '#' . mb_substr($georgianQuote, 0, $quoteLength);

	$this->actingAs($user);

	$response = $this->withCookie('locale', 'ka')->get(route('quotes.index', ['filter[search]' => $searchValue]));

	$response->assertStatus(200);

	$quotes = $response->json('data');

	foreach ($quotes as $quote) {
		$searchValueWithoutSign = mb_substr($searchValue, 1);

		$valueInQuote = stripos($quote['quote'], $searchValueWithoutSign);

		$this->assertNotFalse($valueInQuote);
	}
});

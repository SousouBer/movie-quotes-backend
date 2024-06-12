<?php

use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\UploadedFile;

test('New movie is successfully created', function () {
	$user = User::factory()->create();

	$this->actingAs($user);

	$poster = UploadedFile::fake()->image('poster.png');

	$movieData = [
		'title' => [
			'en' => 'Movie title',
			'ka' => 'ფილმის სახელი',
		],
		'description' => [
			'en' => 'Description in English',
			'ka' => 'აღწერა ქართულად',
		],
		'director' => [
			'en' => 'Director in English',
			'ka' => 'რეჟისორი ქართულად',
		],
		'poster' => $poster,
		'year'   => '2023',
		'budget' => '5000000',
		'genres' => [1, 2],
	];

	$response = $this->post(route('movies.store'), $movieData);

	$response->assertStatus(201)->assertJson(['message' => 'Movie added successfully']);

	$response->assertSessionDoesntHaveErrors(
		[
			'title.en',
			'title.ka',
			'description.en',
			'description.ka',
			'director.en',
			'director.ka',
			'genres',
			'budget',
			'year',
		]
	);

	$this->assertDatabaseHas('movies', [
		'title->en' => 'Movie title',
		'title->ka' => 'ფილმის სახელი',
	]);
});

test('New movie can not be created if no values are passed', function () {
	$user = User::factory()->create();

	$this->actingAs($user);

	$response = $this->post(route('movies.store'));

	$response->assertStatus(302);

	$response->assertSessionHasErrors(
		[
			'title.en',
			'title.ka',
			'description.en',
			'description.ka',
			'director.en',
			'director.ka',
			'genres',
			'budget',
			'year',
		]
	);
});

test('New movie can not be created if no poster was provided', function () {
	$user = User::factory()->create();

	$this->actingAs($user);

	$movieData = [
		'title' => [
			'en' => 'No poster movie',
			'ka' => 'ახალი ფილმის სახელი',
		],
		'description' => [
			'en' => 'Description in English',
			'ka' => 'აღწერა ქართულად',
		],
		'director' => [
			'en' => 'Director in English',
			'ka' => 'რეჟისორი ქართულად',
		],
		'year'   => '2023',
		'budget' => '5000000',
		'genres' => [1, 2],
	];

	$response = $this->post(route('movies.store'), $movieData);

	$response->assertStatus(302);

	$response->assertSessionDoesntHaveErrors(
		[
			'title.en',
			'title.ka',
			'description.en',
			'description.ka',
			'director.en',
			'director.ka',
			'genres',
			'budget',
			'year',
		]
	);

	$response->assertSessionHasErrors(
		[
			'poster',
		]
	);

	$this->assertDatabaseMissing('movies', [
		'title->en' => 'No poster movie',
	]);
});

test('Movie can be successfully edited', function () {
	$user = User::factory()->create();

	$this->actingAs($user);

	$movie = Movie::inRandomOrder()->firstOrFail();

	$poster = UploadedFile::fake()->image('newPoster.png');

	$editedMovieData = [
		'title'    => [
			'en' => 'Movie title',
			'ka' => 'ფილმის სახელი',
		],
		'description' => [
			'en' => 'Description in English',
			'ka' => 'აღწერა ქართულად',
		],
		'director' => [
			'en' => 'Director in English',
			'ka' => 'რეჟისორი ქართულად',
		],
		'poster' => $poster,
		'year'   => '2023',
		'budget' => '5000000',
		'genres' => [1, 2],
	];

	$response = $this->patch(route('movies.update', ['movie' => $movie->id]), $editedMovieData);

	$response->assertStatus(201)->assertJson(['message' => 'Movie updated successfully']);

	$response->assertSessionDoesntHaveErrors(
		[
			'title.en',
			'title.ka',
			'description.en',
			'description.ka',
			'director.en',
			'director.ka',
			'genres',
			'budget',
			'year',
		]
	);

	$this->assertEquals(Movie::findOrFail($movie->id)->title, $editedMovieData['title']['en']);
});

test('Movie can be successfully deleted', function () {
	$user = User::factory()->create();

	$this->actingAs($user);

	$movie = Movie::inRandomOrder()->firstOrFail();

	$response = $this->delete(route('movies.destroy', ['movie' => $movie->id]));

	$response->assertStatus(200)->assertJson(['message' => 'Movie deleted successfully']);

	$this->assertDatabaseMissing('movies', ['id' => $movie->id]);
});

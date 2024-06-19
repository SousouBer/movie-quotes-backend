<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Genre;
use App\Models\Like;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run(): void
	{
		$this->call([
			GenreSeeder::class,
		]);

		$genres = Genre::all();

		User::factory(rand(1, 2))->create()->each(function ($user) use ($genres) {
			Movie::factory(rand(1, 5))->create([
				'user_id' => $user->id,
			])->each(function ($movie) use ($genres, $user) {
				$movie->genres()->attach($genres->random(rand(1, 10)));

				Quote::factory(rand(1, 2))->create([
					'user_id'  => $user->id,
					'movie_id' => $movie->id,
				])->each(function ($quote) use ($user) {
					Comment::factory(rand(1, 5))->create([
						'user_id'  => $user->id,
						'quote_id' => $quote->id,
					]);

					Like::factory()->create([
						'user_id'  => $user->id,
						'quote_id' => $quote->id,
					]);
				});
			});
		});
	}
}

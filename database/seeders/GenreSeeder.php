<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class GenreSeeder extends Seeder
{
	public function run(): void
	{
		$genres = Config::get('genres.genres');

		foreach ($genres as $genre) {
			Genre::create([
				'title' => $genre,
			]);
		}
	}
}

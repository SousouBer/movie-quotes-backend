<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$this->call([
			GenreSeeder::class,
		]);

		User::factory()->create([
			'username'  => 'Test User',
			'email'     => 'test@example.com',
		]);
	}
}

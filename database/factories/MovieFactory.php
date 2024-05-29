<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
	public function definition(): array
	{
		return [
			'title' => [
				'en' => fake()->words(rand(2, 5), true),
				'ka' => fake('ka_GE')->words(rand(2, 5), true),
			],
			'description' => [
				'en' => fake()->realText(100),
				'ka' => fake('ka_GE')->realText(100),
			],
			'director' => [
				'en' => fake()->name(),
				'ka' => fake('ka_GE')->name(),
			],
			'poster'   => fake()->imageUrl(),
			'year'     => fake()->year,
			'budget'   => number_format(fake()->numberBetween(1000, 1000000)),
		];
	}
}

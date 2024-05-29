<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
	public function definition(): array
	{
		return [
			'quote' => [
				'en' => fake()->realtext(50),
				'ka' => fake('ka_GE')->realtext(50),
			],
			'picture'   => fake()->imageUrl(),
		];
	}
}

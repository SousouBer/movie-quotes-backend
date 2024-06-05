<?php

namespace App\Http\Requests;

use App\Rules\EnglishLetters;
use App\Rules\GeorgianLetters;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'user_id'            => 'required|exists:users,id',
			'title.en'           => ['required', new EnglishLetters],
			'title.ka'           => ['required', new GeorgianLetters],
			'description.en'     => ['required',  new EnglishLetters],
			'description.ka'     => ['required', new GeorgianLetters],
			'director.en'        => ['required',  new EnglishLetters],
			'director.ka'        => ['required', new GeorgianLetters],
			'poster'             => 'required|image|mimes:jpg,jpeg,png,gif',
			'year'               => 'required|string',
			'budget'             => 'required|string',
			'genres'             => 'required|array',
			'genres.*'           => 'integer|exists:genres,id',
		];
	}

	public function attributes(): array
	{
		return [
			'title.en'           => __('movies.movie_title_english'),
			'title.ka'           => __('movies.movie_title_georgian'),
			'description.en'     => __('movies.movie_description_english'),
			'description.ka'     => __('movies.movie_description_georgian'),
			'director.en'        => __('movies.movie_director_english'),
			'director.ka'        => __('movies.movie_director_georgian'),
			'poster'             => __('movies.poster'),
			'year'               => __('movies.year'),
			'genres'             => __('movies.genres'),
		];
	}

	protected function prepareForValidation(): void
	{
		$this->merge(
			[
				'user_id'            => auth()->user()->id,
			]
		);
	}
}

<?php

namespace App\Http\Requests;

use App\Rules\EnglishLetters;
use App\Rules\GeorgianLetters;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'user_id'              => 'required|exists:users,id',
			'movie_id'             => 'required|exists:movies,id',
			'quote.en'             => ['required', new EnglishLetters],
			'quote.ka'             => ['required', new GeorgianLetters],
			'picture'              => 'required|image|mimes:jpg,jpeg,png,gif',
		];
	}

	protected function prepareForValidation(): void
	{
		$this->merge(
			[
				'user_id' => auth()->user()->id,
			]
		);
	}
}

<?php

namespace App\Http\Requests;

use App\Rules\EnglishLetters;
use App\Rules\GeorgianLetters;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'quote.en'             => ['required', new EnglishLetters],
			'quote.ka'             => ['required', new GeorgianLetters],
			'picture'              => 'sometimes|image|mimes:jpg,jpeg,png,gif',
		];
	}
}

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
			'title.en'           => ['required', new EnglishLetters],
			'title.ka'           => ['required', new GeorgianLetters],
			'description.en'     => ['required',  new EnglishLetters],
			'description.ka'     => ['required', new GeorgianLetters],
			'director.en'        => ['required',  new EnglishLetters],
			'director.ka'        => ['required', new GeorgianLetters],
			'poster'             => 'required|image|mimes:jpg,jpeg,png,gif',
			'year'               => 'required|string',
			'budget'             => 'required|string',
		];
	}
}

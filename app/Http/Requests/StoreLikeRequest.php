<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLikeRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'user_id'  => 'required|exists:users,id',
			'quote_id' => 'required|exists:quotes,id',
			'is_liked' => 'required|boolean',
		];
	}

	protected function prepareForValidation(): void
	{
		$this->merge(
			[
				'user_id'            => auth()->user()->id,
				'is_liked'           => true,
			]
		);
	}
}

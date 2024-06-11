<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'user_id'  => 'required|exists:users,id',
			'quote_id' => 'required|exists:quotes,id',
			'comment'  => 'required|string',
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

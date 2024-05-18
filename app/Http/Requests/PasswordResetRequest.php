<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'password'  => 'required|min:8|max:15|lowercase|alpha_num|confirmed',
		];
	}
}

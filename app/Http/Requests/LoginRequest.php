<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'username_or_email'             => 'required|min:3',
			'password'                      => 'required',
		];
	}
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'username'  => 'required|min:3|max:15|lowercase|alpha_num|unique:users,username',
			'email'     => 'required|email|unique:users,email',
			'password'  => 'required|min:8|max:15|lowercase|alpha_num|confirmed',
		];
	}
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'avatar'    => 'sometimes|image|mimes:jpg,jpeg,png,gif',
			'username'  => 'sometimes|min:3|max:15|lowercase|alpha_num|unique:users,username',
			'password'  => 'sometimes|min:8|max:15|lowercase|alpha_num|confirmed',
		];
	}
}

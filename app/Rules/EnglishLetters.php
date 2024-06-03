<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnglishLetters implements ValidationRule
{
	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
		if (!preg_match('/^[a-zA-Z \p{P}]+$/', $value)) {
			$fail(__('validation.english_letters'));
		}
	}
}

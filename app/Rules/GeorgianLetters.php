<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GeorgianLetters implements ValidationRule
{
	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
		if (!preg_match('/^[\p{Georgian} \p{P}]+$/u', $value)) {
			$fail(__('validation.georgian_letters'));
		}
	}
}

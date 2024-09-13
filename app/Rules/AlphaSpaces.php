<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphaSpaces implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^[a-zA-Z\s]+$/', $value);
    }

    public function message()
    {
        return 'The :attribute may only contain letters and spaces.';
    }
}
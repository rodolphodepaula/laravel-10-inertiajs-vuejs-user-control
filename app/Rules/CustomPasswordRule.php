<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomPasswordRule implements Rule
{
    public function passes($attribute, $value)
    {
        return strlen($value) >= 6;
    }

    public function message()
    {
        return 'A senha deve ter pelo menos 6 caracteres.';
    }
}
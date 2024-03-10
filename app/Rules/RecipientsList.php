<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class RecipientsList implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       $recipients = explode(',', $value);
        foreach ($recipients as $recipient)
        {
            if(!preg_match('/^@[a-z0-9_]{5,}$/', trim($recipient)))
            {
                $fail('
                    Каждый username должен начинаться с символа @ и отделяться запятой от предыдущего,
                    так же username должен быть корректным по правилам Телеграм
                ');
            }
        }
    }
}

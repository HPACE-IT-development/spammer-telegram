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
            if(!preg_match('/^https:\/\/t.me\/[A-z0-9\/]{5,32}(\/[0-9])*$/', trim($recipient)))
            {
                $fail('
                    Каждый получатель(приватный чат, группа, подгруппа) должен быть корректной tg URLs скопированной из профиля и
                    отделённой от предыдущей запятой ",".
                ');
            }
        }
    }
}

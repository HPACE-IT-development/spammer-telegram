<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class RecipientsList implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       $recipients = explode(',', $value);
        foreach ($recipients as $recipient)
        {
            if(!preg_match('/^https:\/\/t.me\/[A-z0-9\/]{5,32}*$/', trim($recipient)))
            {
                $fail('
                    Каждый получатель(приватный чат, группа) должен быть корректной tg URLs скопированной из профиля и
                    отделённой от предыдущей запятой ",".
                ');
            }
        }
    }
}

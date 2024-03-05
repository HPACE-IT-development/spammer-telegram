<?php

namespace App\Livewire\Forms;

use App\Helpers\MadelineHelper;
use App\Models\Bot;
use danog\MadelineProto\API;
use danog\MadelineProto\RPCErrorException;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BotPhoneForm extends Form
{
    #[Validate('regex:/^\+[0-9]+/', message: 'Неверный формат номера.')]
    public string $phone = '';

    public function store(): void
    {
        $this->validate();

        $madeline = new API(MadelineHelper::getMadelinePath($this->phone), MadelineHelper::getMadelineSettings());
        $authorizationStatus = $madeline->getAuthorization();

        match ($authorizationStatus) {
            0 => call_user_func(function () use($madeline) {
                try {
                    $madeline->phoneLogin($this->phone);

                    Bot::create([
                        'user_id' => auth()->id(),
                        'auth_status' => 1,
                        'phone' => $this->phone
                    ]);

                } catch (RPCErrorException $e) {
                    match ($e->getMessage()) {
                        'PHONE_NUMBER_INVALID' => $this->addError('phone', 'Неверный номер телефона.'),
                        default => Log::debug($e->getMessage())
                    };
                }
            }),
        };
    }
}

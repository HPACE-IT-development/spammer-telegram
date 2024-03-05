<?php

namespace App\Livewire\Forms;

use App\Helpers\MadelineHelper;
use App\Models\Bot;
use danog\MadelineProto\API;
use Illuminate\Support\Facades\Log;
use Livewire\Form;

class BotLoginPasswordForm extends Form
{
    public string $password = '';

    public function confirm(Bot $bot): string
    {
        $madeline = new API(MadelineHelper::getMadelinePath($bot->phone));
        try {
            $authorization = $madeline->complete2faLogin($this->password);
            $bot->update([
                'auth_status' => 3,
                'new' => false
            ]);
            return $authorization['_'];
        } catch (\Exception $e) {
            switch ($e->getMessage()) {
                case 'PASSWORD_HASH_INVALID':
                    $this->addError('password', 'Неверный пароль!');
                    break;
            }
            return $e->getMessage();
        }
    }
}

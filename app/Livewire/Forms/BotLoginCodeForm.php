<?php

namespace App\Livewire\Forms;

use App\Helpers\MadelineHelper;
use App\Models\Bot;
use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use danog\MadelineProto\RPCErrorException;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BotLoginCodeForm extends Form
{
    public string $code = '';

    public function confirm(Bot $bot): string
    {
        $this->validate();

        $madeline = new API(MadelineHelper::getMadelinePath($bot->phone));

        try {
            $authorization = $madeline->completePhoneLogin($this->code);
            if ($authorization['_'] === 'account.password') $bot->update(['auth_status' => 2]);
            else if($authorization['_'] === 'auth.authorization') {
                $bot->update([
                    'auth_status' => 3,
                    'new' => false
                ]);
            }
            return $authorization['_'];
        } catch (\Exception $e) {
            switch ($e->getMessage()) {
                case 'PHONE_CODE_INVALID':
                    $this->addError('code', 'Вы ввели неверный проверочный код!');
                    break;
                case "I'm not waiting for the code! Please call the phoneLogin method first":
                    $this->addError('code', 'Неверный код. Повторите попытку!');
                    $madeline->phoneLogin($bot->phone);
                    break;
            }
            return $e->getMessage();
        }
    }
}

<?php

namespace App\Livewire\Forms;

use App\Enums\TelegramAuthStatusEnum;
use App\Helpers\MadelineHelper;
use App\Models\Bot;
use danog\MadelineProto\API;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BotCreateForm extends Form
{
    public string $phone = '';

    public string $code = '';

    public string $password = '';

    public function phoneRules(): array
    {
        return [
            'phone' => ['required', 'regex:/^\+[0-9]+$/', 'unique:bots']
        ];
    }

    public function codeRules(): array
    {
        return [
            'code' => ['required', 'string']
        ];
    }

    public function passwordRules(): array
    {
        return [
            'password' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'Обязательное поле.',
            '*.regex' => 'Неверный формат.',
            'phone.unique' => 'Этот номер телефона уже есть в системе'
        ];
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function phoneLogin(): ?int
    {
        $this->validate($this->phoneRules());
        $madeline = new API(MadelineHelper::getMadelinePath($this->phone), MadelineHelper::getMadelineSettings());
        $authStatusEnum = TelegramAuthStatusEnum::from($madeline->getAuthorization());

        $bot = Bot::create([
            'user_id' => auth()->id(),
            'status_id' => 1,
            'phone' => $this->phone
        ]);

        return match ($authStatusEnum)
        {
            TelegramAuthStatusEnum::WAITING_CODE => TelegramAuthStatusEnum::WAITING_CODE->value,
            TelegramAuthStatusEnum::WAITING_PASSWORD => TelegramAuthStatusEnum::WAITING_PASSWORD->value,
            TelegramAuthStatusEnum::NOT_LOGGED_IN => call_user_func(function () use($madeline, $bot) {
                try {
                    $madeline->phoneLogin($this->phone);
                    return TelegramAuthStatusEnum::WAITING_CODE->value;
                } catch (\Exception $e) {
                    $this->addError('phone', $e->getMessage());
                    $bot->delete();
                    $madeline->logout();
                    return null;
                }
            }),
        };
    }

    public function completePhoneLogin(API $madeline): ?int
    {
        $this->validate($this->codeRules());
        try {
            $response = $madeline->completePhoneLogin($this->code);

            return match ($response['_']) {
                'auth.authorization' => call_user_func(function () {
                    $this->reset('phone', 'code');
                    return TelegramAuthStatusEnum::LOGGED_IN->value;
                }),
                'account.password' => TelegramAuthStatusEnum::WAITING_PASSWORD->value,
            };
        } catch (\Exception $e) {
            $message = $e->getMessage();
            switch ($message) {
                case "I'm not waiting for the code! Please call the phoneLogin method first":
                    $this->addError('code', 'Проверьте сообщение с кодом еще раз и повторите попытку.');
                    $madeline->phoneLogin($this->phone);
                    break;
                default:
                    $this->addError('code', $message);
            }
            return null;
        }
    }

    public function complete2FaLogin(API $madeline, Bot $bot): ?TelegramAuthStatusEnum
    {
        $this->validate($this->passwordRules());

        try {
            $response = $madeline->complete2faLogin($this->password);
            match ($response['_']) {
                'auth.authorization' => call_user_func(function () use($bot){
                    $bot->update([
                        'status_id' => 2
                    ]);

                    return TelegramAuthStatusEnum::LOGGED_IN;
                }),
                default => null
            };
        } catch (\Exception $e) {
            $this->addError('password', $e->getMessage());
            return null;
        }
    }

    public function resetAll(): void
    {
        $this->reset('phone', 'code', 'password');
    }
}

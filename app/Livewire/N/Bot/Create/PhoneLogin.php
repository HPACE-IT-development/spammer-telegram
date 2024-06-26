<?php

namespace App\Livewire\N\Bot\Create;

use App\Enums\TelegramAuthStatusEnum;
use App\Helpers\MadelineHelper;
use App\Models\Bot;
use danog\MadelineProto\API;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PhoneLogin extends Component
{
    #[Validate('required')]
    #[Validate('regex:/^\+[0-9]+$/')]
    #[Validate('unique:bots')]
    public string $phone = '';

    public ?Bot $bot;

    public function save()
    {
        $this->validate();

        $madeline = new API(MadelineHelper::getMadelinePath($this->phone), MadelineHelper::getMadelineSettings());
        $authStatusEnum = TelegramAuthStatusEnum::from($madeline->getAuthorization());

        if($authStatusEnum == TelegramAuthStatusEnum::NOT_LOGGED_IN)
        {
            try {
                $madeline->phoneLogin($this->phone);

                $bot = Bot::create([
                    'user_id' => auth()->id(),
                    'status_id' => 1,
                    'phone' => $this->phone
                ]);

                $this->reset();
                $this->dispatch('bot-create-next');
            } catch (\Exception $e) {
                $this->addError('phone', $e->getMessage());
                $madeline->logout();
            }
        }
        else
        {
            $this->addError('phone', 'Неизвестная ошибка');
        }
    }

    public function render()
    {
        return view('livewire.n.bot.create.phone-login');
    }
}

<?php

namespace App\Livewire\N\Bot\Create;

use App\Enums\TelegramAuthStatusEnum;
use App\Helpers\MadelineHelper;
use App\Models\Bot;
use danog\MadelineProto\API;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Complete2FaLogin extends Component
{
    #[Validate('required')]
    #[Validate('string')]
    public string $password = '';

    public Bot $bot;

    public function mount($bot): void
    {
        $this->bot = $bot;
    }

    public function save()
    {
        $this->validate();
        $madeline = new API(MadelineHelper::getMadelinePath($this->bot->phone));

        try {
            $response = $madeline->complete2faLogin($this->password);
            switch ($response['_']) {
                case 'auth.authorization':
                    $this->reset('password');
                    $this->dispatch('bot-create-success');
                    break;
                default:
                    $this->addError('password', 'Ошибки нет,но что-то пошло не так.');
            }
        } catch (\Exception $e) {
            $this->addError('password', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.n.bot.create.complete2-fa-login');
    }
}

<?php

namespace App\Livewire\N\Bot\Create;

use App\Enums\TelegramAuthStatusEnum;
use App\Helpers\MadelineHelper;
use App\Models\Bot;
use danog\MadelineProto\API;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CompletePhoneLogin extends Component
{
    #[Validate('required')]
    #[Validate('string')]
    public string $code = '';

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
            $response = $madeline->completePhoneLogin($this->code);
            switch ($response['_']) {
                case 'auth.authorization':
                    $this->reset();
                    $this->dispatch('bot-create-success');
                    break;
                case 'account.password':
                    $this->dispatch('bot-create-next');
                    break;
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            switch ($message) {
                case "I'm not waiting for the code! Please call the phoneLogin method first":
                    $this->addError('code', 'Проверьте сообщение с кодом еще раз и повторите попытку.');
                    $madeline->phoneLogin($this->bot->phone);
                    break;
                default:
                    $this->addError('code', $message);
            }
        }
    }

    public function render()
    {
        return view('livewire.n.bot.create.complete-phone-login');
    }
}

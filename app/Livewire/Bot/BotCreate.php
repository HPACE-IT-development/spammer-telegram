<?php

namespace App\Livewire\Bot;

use App\Enums\TelegramAuthStatusEnum;
use App\Helpers\MadelineHelper;
use App\Livewire\Forms\BotCreateForm;
use App\Models\Bot;
use danog\MadelineProto\API;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BotCreate extends Component
{
    /* Если authStatus пустой => нет нового добавленного акка в БД */
    public int $authStatus;

    public BotCreateForm $form;

    public function mount(): void
    {
        if(!is_null($this->bot))
        {
            $madeline = new API(MadelineHelper::getMadelinePath($this->bot->phone));
            $this->authStatus = $madeline->getAuthorization();
            $this->form->setPhone($this->bot->phone);
        }
    }

    #[Computed]
    public function bot()
    {
        return Bot::whereHas('status', function ($query) {
            $query->where('name', 'Новый');
        })
            ->where('user_id', auth()->id())
            ->first();
    }

    #[Computed]
    public function madeline()
    {
        return !empty($this->form->phone)? new API(MadelineHelper::getMadelinePath($this->form->phone)): null;
    }

    public function phoneLogin(): void
    {
        $result = $this->form->phoneLogin();
        if($result)
        {
            $this->authStatus = $result;
            unset($this->bot);
            unset($this->madeline);
        }
    }

    public function completePhoneLogin(): void
    {
        $result = $this->form->completePhoneLogin($this->madeline);
        if($result)
        {
            if(TelegramAuthStatusEnum::from($result) == TelegramAuthStatusEnum::LOGGED_IN)
            {
                $this->resetComponent();
            }
            else if(TelegramAuthStatusEnum::from($result) == TelegramAuthStatusEnum::WAITING_PASSWORD)
            {
                $this->authStatus = $result;
            }
        }
    }

    public function complete2FaLogin(): void
    {
        $result = $this->form->complete2FaLogin($this->madeline, $this->bot);
        if($result)
        {
            if($result == TelegramAuthStatusEnum::LOGGED_IN)
            {
                $this->resetComponent('completion');
            }
        }
    }

    public function resetComponent(string $type): void
    {
        if($type === 'remove')
        {
            $this->madeline->logout();
            $this->bot->delete();
        }

        $this->form->resetAll();
        unset($this->bot);
        unset($this->madeline);
        $this->reset('authStatus');
    }

    public function render()
    {
        return view('livewire.bot.bot-create', [
            'bot' => $this->bot
        ]);
    }
}










//public function complete2FALogin(): void
//{
//    $status = $this->passwordForm->confirm($this->bot);
//    if($status === 'auth.authorization') {
//        unset($this->bot);
//        $this->reset('phoneForm', 'codeForm', 'passwordForm');
//    }
//}
//
//public function completePhoneLogin(): void
//{
//    $status = $this->codeForm->confirm($this->bot);
//    if($status === 'auth.authorization') {
//        unset($this->bot);
//        $this->reset('phoneForm', 'codeForm');
//    }
//}
//
//public function phoneLogin(): void
//{
//    $this->phoneForm->store();
//}

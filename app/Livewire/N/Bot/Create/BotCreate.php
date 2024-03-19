<?php

namespace App\Livewire\N\Bot\Create;

use App\Models\Bot;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class BotCreate extends Component
{
    public string $currentStep = 'n.bot.create.phone-login';

    public array $steps = [
        'n.bot.create.phone-login',
        'n.bot.create.complete-phone-login',
        'n.bot.create.complete2-fa-login'
    ];

    #[Computed]
    public function bot()
    {
        return Bot::where('user_id', auth()->id())
            ->whereHas('status', function ($query) {
                $query->where('title', 'new');
            })->first();
    }

    #[On('bot-create-next')]
    public function next(): void
    {
        $currentIndex = array_search($this->currentStep, $this->steps);
        $this->currentStep = $this->steps[$currentIndex + 1];
    }

    #[On('bot-create-success')]
    public function success(): void
    {
        $this->bot->update(['status_id' => 2]);
        $this->dispatch('refresh-bot-index',
            status: 'success',
            message: "Аккаунт {$this->bot->phone} успешно добавлен."
        );

        $this->reset('currentStep');
        unset($this->bot);
        $this->dispatch('hide-bot-create-modal');
    }

    public function render()
    {
        return view('livewire.n.bot.create.bot-create', [
            'bot' => $this->bot
        ]);
    }
}

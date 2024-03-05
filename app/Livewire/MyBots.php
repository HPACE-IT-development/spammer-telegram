<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MyBots extends Component
{
    public array $panes = [
        'create' => 'Добавить аккаунт',
        'jobs' => 'Задачи',
        'settings' => 'Настройки'
    ];

    public string $activePane = 'create';

    public function showPane($paneKey): void
    {
        $this->activePane = $paneKey;
        $this->dispatch('bot-index:remove-filters');
    }

    public function render()
    {
        return view('livewire.my-bots');
    }
}

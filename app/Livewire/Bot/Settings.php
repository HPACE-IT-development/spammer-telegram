<?php

namespace App\Livewire\Bot;

use Livewire\Component;

class Settings extends Component
{
    public array $settingsItems = [
        'groups' => 'Гуппы',
        'item2' => 'Пункт2',
        'item3' => 'Пункт3',
    ];

    public string $activeSettingsItem = 'groups';

    public function changeActiveItem($itemKey): void
    {
        $this->activeSettingsItem = $itemKey;
    }

    public function render()
    {
        return view('livewire.bot.settings');
    }
}

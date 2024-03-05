<?php

namespace App\Livewire\Bot;

use App\Models\BotGroup;
use App\Models\BotStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Filter extends Component
{
    public array $statuses;

    public int $selectedStatusId; // любой

    public array $groups;

    public int $selectedGroupId;

    public function mount(): void
    {
        $this->statuses = BotStatus::select('id', 'name')
            ->where('name','!=', 'Новый')
            ->get()
            ->toArray();

        $this->statuses[] = ['id' => -1, 'name' => 'Любой'];
        $this->selectedStatusId = -1;


        $this->groups = BotGroup::select('id', 'name')
            ->where('user_id', auth()->id())
            ->get()
            ->toArray();

        $this->groups[] = ['id' => 0, 'name' => 'Без группы'];
        $this->groups[] = ['id' => -1, 'name' => 'Любая'];
        $this->selectedGroupId = -1;
    }

    public function save(): void
    {
        $this->dispatch(
            'filter-save',
            group_id: $this->selectedGroupId,
            status_id: $this->selectedStatusId
        );
    }

    public function render()
    {
        return view('livewire.bot.filter');
    }
}

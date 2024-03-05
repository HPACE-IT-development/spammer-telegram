<?php

namespace App\Livewire\Settings\Group;

use App\Models\BotGroup;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class GroupIndex extends Component
{
    public string $activePane; // create or details
    public int $activeGroupKey = -1;

    #[Computed]
    public function groups()
    {
        return BotGroup::where('user_id', auth()->id())->get();
    }

    public function mount(): void
    {
        $this->activePane = 'create';
    }

    public function setActivePane(string $window, int $groupKey = -1): void
    {
        $this->activePane = $window;
        $this->activeGroupKey = $groupKey;
        $this->dispatch(
            'filter-save',
            group_id: ($groupKey !== -1)? $this->groups[$groupKey]->id: -1
        );
    }

    #[On('group-created')]
    public function updateGroups(): void
    {
        unset($this->groups);
    }

    public function render()
    {
        return view('livewire.settings.group.group-index', [
            'groups' => $this->groups
        ]);
    }
}

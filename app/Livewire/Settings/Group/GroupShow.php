<?php

namespace App\Livewire\Settings\Group;

use App\Livewire\Forms\GroupForm;
use App\Models\BotGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class GroupShow extends Component
{
    public GroupForm $form;

    #[Reactive]
    public Collection $groups;
    #[Reactive]
    public int $activeGroupKey;

    #[Computed]
    public function group(): BotGroup
    {
        return $this->groups[$this->activeGroupKey];
    }

    #[Computed]
    public function rows(): int
    {
        return ceil(mb_strlen($this->group->description) / 39);
    }

    public function startBotListManagement(int $groupId): void
    {
        $this->dispatch('edit-group-members', groupId: $groupId);
    }

    public function removeBots()
    {

    }

    public function render()
    {
        return view('livewire.settings.group.group-show', [
            'group' => $this->group,
            'rows' => $this->rows
        ]);
    }
}

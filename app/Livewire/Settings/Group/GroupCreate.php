<?php

namespace App\Livewire\Settings\Group;

use App\Livewire\Forms\GroupForm;
use Livewire\Component;

class GroupCreate extends Component
{
    public GroupForm $form;

    public function save(): void
    {
        if($this->form->store()) $this->dispatch('group-created');
    }

    public function render()
    {
        return view('livewire.settings.group.group-create');
    }
}

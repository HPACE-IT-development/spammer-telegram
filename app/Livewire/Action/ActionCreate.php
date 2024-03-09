<?php

namespace App\Livewire\Action;

use App\Livewire\Forms\ActionCreateForm;
use Livewire\Component;

class ActionCreate extends Component
{
    public ActionCreateForm $form;

    public function save()
    {
        $this->form->store();
    }

    public function render()
    {
        return view('livewire.action.action-create');
    }
}

<?php

namespace App\Livewire\Action;

use App\Livewire\Forms\ActionCreateForm;
use App\Livewire\Newsletter;
use Livewire\Component;

class ActionCreate extends Component
{
    public ActionCreateForm $form;

    public function save()
    {
        if($this->form->store())
        {
            session()->flash('success', 'Рассылка успешно создана, для назначения запуска перейдите Мои боты->задачи');
            $this->redirect(Newsletter::class);
        }
    }

    public function render()
    {
        return view('livewire.action.action-create');
    }
}

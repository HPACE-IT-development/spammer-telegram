<?php

namespace App\Livewire\Action;

use App\Livewire\Forms\ActionCreateNewsletterForm;
use App\Livewire\Newsletter;
use Livewire\Component;

class ActionCreate extends Component
{
    public ActionCreateNewsletterForm $form;

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

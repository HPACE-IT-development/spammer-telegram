<?php

namespace App\Livewire\N\Action;

use App\Livewire\Forms\ActionCreateNewsletterForm;
use App\Models\ActionType;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ActionCreate extends Component
{
    public ActionCreateNewsletterForm $newsletterForm;

    public string $selectedActionType = 'any';

    #[Computed]
    public function types(): array
    {
        $types = ActionType::all()->toArray();
        $types[] = ['title' => 'any', 'desc_ru' => 'Выберите тип'];
        return $types;
    }

    public function save(): void
    {
        if($this->selectedActionType === 'newsletter')
        {
            if($this->newsletterForm->store()) {
                $this->dispatch('action-index-refresh',
                    status: 'success',
                    message: "Успешное добавление новой задачи."
                );
                $this->reset();
                $this->dispatch('hide-action-create-modal');
            }
        }
    }

    public function cancel(): void
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.n.action.action-create', [
            'types' => $this->types
        ]);
    }
}

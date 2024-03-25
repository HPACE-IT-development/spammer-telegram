<?php

namespace App\Livewire\N\Action;

use App\Livewire\Forms\ActionCreateNewsletterForm;
use App\Models\ActionType;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ActionCreate extends Component
{
    public ActionCreateNewsletterForm $newsletterForm;

    public string $selectedType = 'any';

    #[Computed]
    public function types(): array
    {
        $types = ActionType::all()->toArray();
        $types[] = ['title' => 'any', 'desc_ru' => 'Выберите тип'];
        return $types;
    }

    public function save(): void
    {
        if($this->selectedType === 'newsletter')
        {
            if($this->newsletterForm->store()) {
                $this->dispatch('refresh-action-index',
                    status: 'success',
                    message: "Успешное добавление новой задачи."
                );
                $this->selectedType = 'any';
                $this->dispatch('hide-action-create-modal');
            }
        }
    }

    public function render()
    {
        return view('livewire.n.action.action-create', [
            'types' => $this->types
        ]);
    }
}

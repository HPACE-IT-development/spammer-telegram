<?php

namespace App\Livewire\N\Action;

use App\Models\ActionType;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ActionCreate extends Component
{
    public string $selectedType = 'any';

    #[Computed]
    public function types(): array
    {
        $types = ActionType::all()->toArray();
        $types[] = ['title' => 'any', 'desc_ru' => 'Выберите тип'];
        return $types;
    }

    public function render()
    {
        return view('livewire.n.action.action-create', [
            'types' => $this->types
        ]);
    }
}

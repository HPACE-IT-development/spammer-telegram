<?php

namespace App\Livewire\N\Action;

use App\Models\Action;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ActionShow extends Component
{
    public Action $action;
    public ?string $visibleElement = null;

    #[On('action-show-toggle')]
    public function toggleVisibleElement($field): void
    {
        if($this->visibleElement === $field) $this->reset('visibleElement');
        else $this->visibleElement = $field;
    }

    public function render()
    {
        return view('livewire.n.action.action-show');
    }
}

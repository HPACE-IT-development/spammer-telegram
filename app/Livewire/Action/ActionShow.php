<?php

namespace App\Livewire\Action;

use App\Models\Action;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ActionShow extends Component
{
    public Action $action;

    public string $senderType;
    public ?string $visibleElement = null;

    public function toggleVisibleElement($field): void
    {
        if($this->visibleElement === $field) $this->visibleElement = null;
        else $this->visibleElement = $field;
    }

    public function render()
    {
        return view('livewire.action.action-show');
    }
}

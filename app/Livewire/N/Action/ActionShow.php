<?php

namespace App\Livewire\N\Action;

use App\Jobs\ProcessNewsletter;
use App\Models\Action;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ActionShow extends Component
{
    public ?Action $action;
    public ?string $visibleElement = null;

    #[On('action-show-toggle')]
    public function toggleVisibleElement($field): void
    {
        if($this->visibleElement === $field) $this->reset('visibleElement');
        else $this->visibleElement = $field;
    }

    public function performJob(): void
    {
        ProcessNewsletter::dispatch($this->action);
    }

    public function deleteAction(): void
    {
        $this->action->delete();
        $this->dispatch('action-index-refresh',
            status: 'success',
            message: "Успешное удаление задачи."
        );
    }

    public function render()
    {
        return view('livewire.n.action.action-show');
    }
}

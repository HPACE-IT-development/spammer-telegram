<?php

namespace App\Livewire\N\Action;

use App\Helpers\MadelineHelper;
use App\Jobs\ProcessNewsletter;
use App\Models\Action;
use App\Models\ActionStatus;
use App\Models\Report;
use danog\MadelineProto\API;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ActionShow extends Component
{
    public ?Action $action;
    public ?bool $poll;
    public ?string $visibleElement = null;

    #[On('action-show-toggle')]
    public function toggleVisibleElement($field): void
    {
        if($this->visibleElement === $field) $this->reset('visibleElement');
        else $this->visibleElement = $field;
    }

    public function performJob(): void
    {
        $this->action->update(['action_status_id' => 2]);
        $this->dispatch('action-index-refresh')
            ->to(ActionIndex::class);
        $this->action->load('images');
        ProcessNewsletter::dispatch($this->action);
    }

    public function deleteAction(): void
    {
        $this->reset();
        $this->dispatch('action-index-delete-active-action')
            ->to(ActionIndex::class);
    }

    public function render()
    {
        return view('livewire.n.action.action-show');
    }
}

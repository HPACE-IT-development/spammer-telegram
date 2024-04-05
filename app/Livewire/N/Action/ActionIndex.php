<?php

namespace App\Livewire\N\Action;

use App\Models\Action;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.n-app')]
class ActionIndex extends Component
{
    public string $displayedActionStatus = 'created';

    #[Computed]
    public function actions()
    {
        $builder = Action::with('status', 'type', 'performers')
            ->where('user_id', auth()->id());

        return $builder->orderBy('created_at', 'desc')->get();
    }

    #[Computed]
    public function activeAction(): ?Action
    {
        return ($this->actions->isNotEmpty())? $this->actions->first(): null;
    }

    public function toggleActiveAction($collectionKey): void
    {
        $this->activeAction = $this->actions->get($collectionKey);
    }

    #[On('action-index-refresh')]
    public function refreshComponent($status, $message): void
    {
        session()->flash($status, $message);
    }


    public function render()
    {
        return view('livewire.n.action.action-index', [
            'actions' => $this->actions,
            'activeAction' => $this->activeAction
        ]);
    }
}

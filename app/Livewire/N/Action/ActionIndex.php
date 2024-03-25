<?php

namespace App\Livewire\N\Action;

use App\Models\Action;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.n-app')]
class ActionIndex extends Component
{
    public ?Action $activeAction;

    public string $displayedStatus = 'created';

    public function mount(): void
    {
        $this->activeAction = ($this->actions->isNotEmpty())? $this->actions->first(): null;
    }

    #[Computed]
    public function actions()
    {
        $builder = Action::with('status', 'type')
            ->where('user_id', auth()->id());

        return $builder->get();
    }

    public function toggleActiveAction($collectionKey): void
    {
        $this->activeAction = $this->actions->get($collectionKey);
    }

    public function render()
    {
        return view('livewire.n.action.action-index', [
            'actions' => $this->actions
        ]);
    }
}

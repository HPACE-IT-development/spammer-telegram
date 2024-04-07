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

    public ?Action $activeAction;

    public function mount()
    {
        $this->actualizeActiveAction();
        $this->forgetSession(['success', 'danger', 'warning']);
    }

    #[Computed]
    public function actions()
    {
        $builder = Action::with('status', 'type', 'performers', 'images')
            ->where('user_id', auth()->id());

        return $builder->orderBy('created_at', 'desc')->get();
    }

    #[Computed]
    public function isThereStatusInQueueOrAtWork()
    {
        return Action::where('user_id', auth()->user()->id)
            ->whereHas('status', function ($query) {
                $query->where('title', 'in queue')
                    ->orWhere('title', 'at work');
            })
            ->get();
    }

    #[Computed]
    public function isActiveActionStatusAtWork(): bool
    {
        return $this->activeAction->status->title === 'at work';
    }

    public function toggleActiveAction($collectionKey): void
    {
        $this->activeAction = $this->actions->get($collectionKey);
    }

    #[On('action-index-refresh-after-create')]
    public function refreshComponentAfterCreate(): void
    {
        $this->refreshComponent(status: 'success', message: "Успешное добавление новой задачи.");
        $this->actualizeActiveAction();
    }

    #[On('action-index-delete-active-action')]
    public function deleteActiveAction(): void
    {
        $this->activeAction->delete();
        $this->actualizeActiveAction();
    }

    #[On('action-index-refresh')]
    public function refreshComponent($status = null, $message = null): void
    {
        if(isset($status)) session()->put($status, $message);
    }

    public function forgetSession(array $keys): void
    {
        session()->forget($keys);
    }

    public function actualizeActiveAction(): void
    {
        $this->activeAction = ($this->actions->isNotEmpty())? $this->actions->first(): null;
    }


    public function render()
    {
        return view('livewire.n.action.action-index', [
            'actions' => $this->actions,
            'activeAction' => $this->activeAction,
            'isThereStatusInQueueOrAtWork' => $this->isThereStatusInQueueOrAtWork,
            'isActiveActionStatusAtWork' => $this->isActiveActionStatusAtWork()
        ]);
    }
}

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
        $this->updateActiveAction();
    }

    #[Computed]
    public function actions()
    {
        $builder = Action::with('status', 'type', 'performers', 'images')
            ->where('user_id', auth()->id());

        return $builder->orderBy('created_at', 'desc')->get();
    }

    public function toggleActiveAction($collectionKey): void
    {
        $this->activeAction = $this->actions->get($collectionKey);
    }

    #[On('action-index-refresh-after-create')]
    public function refreshComponentAfterCreate($status, $message): void
    {
        $this->refreshComponent($status, $message);
        $this->updateActiveAction();
    }

    #[On('active-index-delete-active-action')]
    public function deleteActiveAction(): void
    {
        $type = $this->activeAction->type->desc_ru;
        $id = $this->activeAction->id;

        $this->activeAction->delete();
        $this->updateActiveAction();
        $this->refreshComponent(
            status: 'success',
            message: "$type #$id успешное удаление."
        );
    }

    #[On('action-index-refresh')]
    public function refreshComponent($status, $message): void
    {
        session()->flash($status, $message);
    }

    public function updateActiveAction(): void
    {
        $this->activeAction = ($this->actions->isNotEmpty())? $this->actions->first(): null;
    }


    public function render()
    {
        return view('livewire.n.action.action-index', [
            'actions' => $this->actions,
            'activeAction' => $this->activeAction
        ]);
    }
}

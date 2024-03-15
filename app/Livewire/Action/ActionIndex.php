<?php

namespace App\Livewire\Action;

use App\Models\Action;
use App\Models\ActionStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ActionIndex extends Component
{
    public string $displayedStatus = 'created';
    public array $displayedTypes = [];

    public ?Action $activeAction;

    public Collection $statuses;

    public function mount(): void
    {
        $this->statuses = ActionStatus::all();
        $this->activeAction = ($this->actions->isNotEmpty())? $this->actions->first(): null;
    }

    #[Computed]
    public function actions()
    {
        $builder = Action::with('status', 'type')
            ->where('user_id', auth()->id())
            ->whereHas('status', function ($query) {
                $query->where('title', $this->displayedStatus);
            });

        if(!$this->displayedStatus) {
            $builder->whereHas('type', function ($query) {
                $query->whereIn('title', $this->displayedTypes);
            });
        }

        return $builder->get();
    }

    public function toggleActiveAction($id): void
    {
        $this->activeAction = Action::where('id', $id)->first();
    }

    public function filter(): void
    {
        unset($this->actions);
    }

    public function render()
    {
        return view('livewire.action.action-index', ['actions' => $this->actions]);
    }
}

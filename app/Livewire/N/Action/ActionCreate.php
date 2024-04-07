<?php

namespace App\Livewire\N\Action;

use App\Livewire\Forms\ActionCreateNewsletterForm;
use App\Models\ActionType;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class ActionCreate extends Component
{
    use WithFileUploads;

    public ActionCreateNewsletterForm $newsletterForm;
    public string $selectedActionType = 'any';

    #[Computed]
    public function types(): array
    {
        $types = ActionType::all()->toArray();
        $types[] = ['title' => 'any', 'desc_ru' => 'Выберите тип'];
        return $types;
    }

    public function save(): void
    {
        if($this->selectedActionType === 'newsletter')
        {
            $this->newsletterForm->store();
            $this->reset('selectedActionType');
            $this->dispatch('hide-action-create-modal')
                ->self();
            $this->dispatch('action-index-refresh-after-create',
                status: 'success',
                message: "Успешное добавление новой задачи."
            )
                ->to(ActionIndex::class);
        }
    }

    public function cancel(): void
    {
        $this->newsletterForm->resetAll();
    }

    public function cancelUploadImage(): void
    {
        $this->newsletterForm->resetImage();
    }

    public function render()
    {
        return view('livewire.n.action.action-create', [
            'types' => $this->types
        ]);
    }
}

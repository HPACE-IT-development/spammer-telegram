<?php

namespace App\Livewire\N\Bot;

use App\Models\Bot;
use App\Models\BotStatus;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class BotIndex extends Component
{
    public string $mode;
    public string $botStatusTitleFilter;

    public array $selectedBots = [];

    public function mount($mode): void
    {
        $this->mode = $mode;
        $this->botStatusTitleFilter = ($mode === 'performers')? 'active': 'any';

    }

    #[Computed]
    public function bots(): Collection
    {
        /* Сначала проверям фильттрацию/сортировку по title статуса бота */
        /* Если есть фильтрация => сортировка не нужна */
        $status = $this->botStatusTitleFilter;

        $botBuilder = Bot::with(['status'])
            ->where('user_id', auth()->id());


        if($status === 'any') {
            $botBuilder->whereHas('status', function ($query) {
                $query->where('title', '!=', 'new');
            });

            $botBuilder->select('bots.*')
                ->join('bot_statuses', 'bot_statuses.id', '=', 'bots.status_id')
                ->orderBy('bot_statuses.importance');
        }
        else {
            $botBuilder->whereHas('status', function ($query) use($status) {
                $query->where('title', $status);
            });
        }

        return $botBuilder->get();
    }

    #[Computed]
    public function filtrationStatuses()
    {
        $statuses = BotStatus::where('importance', '>', 0)->get()->toArray();
        $statuses[] = ['title' => 'any', 'desc_ru' => 'Любой статус', 'id' => 0];
        return $statuses;
    }

    #[On('refresh-bot-index')]
    public function refreshComponent($status = '', $message = ''): void
    {
        session()->flash($status, $message);
        $this->reset();
        unset($this->bots);
    }

    public function toggleSelectedBot($id): void
    {
        $arrayKey = array_search((int) $id, $this->selectedBots);

        if($arrayKey OR $arrayKey === 0) unset($this->selectedBots[$arrayKey]);
        else $this->selectedBots[] = (int) $id;
    }

    public function acceptRemoval(): void
    {
        Bot::destroy($this->selectedBots);
        session()->flash('success', 'Выбранные боты успешно удалены.');
        $this->cancelRemoval();
    }

    public function cancelRemoval(): void
    {
        $this->cancelSelected();
        $this->mode = 'simple';
    }

    public function cancelSelected():void
    {
        $this->reset('selectedBots');
    }

    public function destroyBot($id): void
    {
        session()->flash('success', 'Бот успешно удален.');
        Bot::destroy((int)$id);
    }

    public function render()
    {
        return view('livewire.n.bot.bot-index', [
            'bots' => $this->bots,
            'filtrationStatuses' => $this->filtrationStatuses
        ]);
    }
}

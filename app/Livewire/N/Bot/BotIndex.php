<?php

namespace App\Livewire\N\Bot;

use App\Models\Action;
use App\Models\Bot;
use App\Models\BotStatus;
use App\Models\Performer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class BotIndex extends Component
{
    public string $mode;
    public string $botStatusTitleFilter;


    /* id выбранных ботов в int */
    public array $selectedBots = [];

    public array $actionPerformers = [];

    public ?Action $action;

    public function mount($mode, $action): void
    {
        $this->mode = $mode;

        if($mode === 'performers')
        {
            $this->botStatusTitleFilter = 'active';
            $this->action = $action;


            $actionPerformers = Performer::select('bot_id')
                ->where('action_id', $action->id)
                ->whereHas('bot', function ($query) {
                    $query->whereHas('status', function ($query) {
                        $query->where('title', 'active');
                    });
                })
                ->get()
                ->toArray();


            foreach ($actionPerformers as $performer)
            {
                $this->actionPerformers[] = $performer['bot_id'];
            }

            $this->selectedBots = $this->actionPerformers;
        }
        else
        {
            $this->botStatusTitleFilter = 'any';
        }

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

    #[Computed]
    public function isDiffActionPerformersAndSelectedBots(): bool
    {
        $diff1 = array_diff($this->selectedBots, $this->actionPerformers);
        $diff2 = array_diff($this->actionPerformers, $this->selectedBots);

        $is = false;
        if($diff1 OR $diff2) $is = true;
        return $is;
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

        if($this->mode === 'performers') unset($this->isDiffActionPerformersAndSelectedBots);
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

    public function saveSelectedBots(): void
    {
        if($this->mode === 'performers')
        {
            $rowsArray = [];
            foreach ($this->selectedBots as $bot_id)
            {
                $rowsArray[] = [
                    'bot_id' => $bot_id,
                    'action_id' => $this->action->id
                ];
            }

            DB::table('performers')->whereIn('bot_id', $this->actionPerformers)->delete();
            DB::table('performers')->insert($rowsArray);
            $this->actionPerformers = $this->selectedBots;
        }
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
            'filtrationStatuses' => $this->filtrationStatuses,
            'isDiffActionPerformersAndSelectedBots' => $this->isDiffActionPerformersAndSelectedBots
        ]);
    }
}

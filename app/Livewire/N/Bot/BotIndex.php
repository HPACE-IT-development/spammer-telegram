<?php

namespace App\Livewire\N\Bot;

use App\Helpers\MadelineHelper;
use App\Livewire\N\Action\ActionIndex;
use App\Livewire\N\Action\ActionShow;
use App\Models\Action;
use App\Models\Bot;
use App\Models\BotStatus;
use App\Models\Performer;
use danog\MadelineProto\API;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Js;
use Livewire\Attributes\On;
use Livewire\Component;

class BotIndex extends Component
{
    public string $mode;
    public string $botStatusTitleFilter = 'any';


    /* id выбранных ботов в int */
    public array $selectedBots = [];
    public int $selectedBotsAmount = 0;

    public array $actionPerformers = [];

    public ?Action $action;

    public function mount($mode, $action): void
    {
        $this->mode = $mode;

        if($mode === 'performers')
        {
            $this->action = $action;

            foreach ($action->performers as $performer)
            {
                $this->actionPerformers[] = $performer->id;
            }

            $this->selectedBots = $this->actionPerformers;
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

    #[On('bot-index-refresh-to')]
    public function refreshTo($mode, $status = '', $message = ''): void
    {
        $this->mode = $mode;
        session()->flash($status, $message);
        unset($this->bots);
    }

    public function toggleSelectedBot($id): void
    {
        $arrayKey = array_search((int) $id, $this->selectedBots);

        if($arrayKey OR $arrayKey === 0) {
            unset($this->selectedBots[$arrayKey]);
            if($this->mode === 'removal') $this->selectedBotsAmount = --$this->selectedBotsAmount;
        }
        else {
            $this->selectedBots[] = (int) $id;
            if($this->mode === 'removal') $this->selectedBotsAmount = ++$this->selectedBotsAmount;
        }

        if($this->mode === 'performers') unset($this->isDiffActionPerformersAndSelectedBots);
    }

    public function acceptRemoval(): void
    {
        try {
            $deletedBots = Bot::where('user_id', auth()->user()->id)
                ->whereIn('id', $this->selectedBots)
                ->get();

            foreach ($deletedBots as $bot) {
                $madelineSession = new API(MadelineHelper::getMadelinePath($bot->phone));
                $madelineSession->logout();
                $bot->delete();
            }
            session()->flash('success', 'Выбранные боты успешно удалены.');
        } catch (\Exception $e) {
            session()->flash('danger', 'Произошла неизвестная ошибка.');
        }
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

            DB::table('performers')
                ->where('action_id', $this->action->id)
                ->whereIn('bot_id', $this->actionPerformers)->delete();
            DB::table('performers')->insert($rowsArray);
            $this->actionPerformers = $this->selectedBots;

            $this->dispatch('action-index-refresh',
                status: 'success',
                message: "{$this->action->type->desc_ru} # {$this->action->id}: Успешное добавление исполнителей."
            )
                ->to(ActionIndex::class);

            $this->dispatch('action-show-toggle', 'performers')
                ->to(ActionShow::class);
        }
    }

    public function cancelSelected():void
    {
        switch ($this->mode){
            case 'performers':
                $this->dispatch('action-show-toggle', 'performers');
                break;
            default:
                $this->reset('selectedBots');
        }
    }

    public function destroyBot($id): void
    {
        $bot = Bot::where('id', (int) $id)->first();
        $madelineSession = new API(MadelineHelper::getMadelinePath($bot->phone));

        try {
            $madelineSession->logout();
            $bot->delete();
            session()->flash('success', 'Бот успешно удален.');
        } catch (\Exception $e) {
            session()->flash('danger', 'Произошла неизвестная ошибка.');
        }
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

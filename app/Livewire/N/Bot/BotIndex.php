<?php

namespace App\Livewire\N\Bot;

use App\Models\Bot;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.n-app')]
class BotIndex extends Component
{
//    public string $mode = 'index';

    public ?string $botStatusTitleFilter = null;

    #[Computed]
    public function bots(): Collection
    {
        /* Сначала проверям фильттрацию/сортировку по title статуса бота */
        /* Если есть фильтрация => сортировка не нужна */

        $botBuilder = Bot::with(['status', 'group'])
            ->where('user_id', auth()->id())
            ->whereHas('status', function ($query) {
                $query->where('title', '!=', 'new');
            });


        if(!isset($this->botStatusTitleFilter))
        {
            $botBuilder->join('bot_statuses', 'bot_statuses.id', '=', 'bots.status_id')
                ->orderBy('bot_statuses.importance');
        }

        return $botBuilder->get();
    }

    #[On('refresh-bot-index')]
    public function refreshComponent($status = '', $message = '')
    {
        session()->flash($status, $message);
        $this->reset();
        unset($this->bots);
    }

//    public function changeMode($modeName): void
//    {
//        $this->mode = $modeName;
//    }

    public function render()
    {
        return view('livewire.n.bot.bot-index', [
            'bots' => $this->bots
        ]);
    }
}

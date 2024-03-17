<?php

namespace App\Livewire\N\Bot;

use App\Models\Action;
use App\Models\Bot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.n-app')]
class BotIndex extends Component
{
    public ?string $botStatusTitleFilter = null;

    #[Computed]
    public function bots(): Collection
    {
        /* Сначала проверям фильттрацию/сортировку по title статуса бота */
        /* Если есть фильтрация => сортировка не нужна */

        $botBuilder = Bot::with(['status', 'group'])
            ->where('user_id', auth()->id());


        if(!isset($this->botStatusTitleFilter))
        {
            $botBuilder->join('bot_statuses', 'bot_statuses.id', '=', 'bots.status_id')
                ->orderBy('bot_statuses.importance');
        }

        return $botBuilder->get();
    }

    public function render()
    {
        return view('livewire.n.bot.bot-index', [
            'bots' => $this->bots
        ]);
    }
}

<?php

namespace App\Livewire\Bot;

use App\Models\Bot;
use danog\MadelineProto\API;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class BotIndex extends Component
{
    /*
     * ДОБАВЛЕНИЕ/УДАЛЕНИЕ АККАУНТОВ ИЗ ГРУППЫ
     * При нажатие "добавить" на странице инфы о группе меняется $filterOptions['group_id'] на 0 (без группы)
     * При нажатие на "Убрать" $filterOptions['group_id'] = $group->id
     * В обоих случаях должен меняться тип просмотра: с show на checkbox (show по дефолту - обычный показ)
     */

    public array $selectedBotsIds;
    public array $addedBotsIds;

    public string $viewType = 'show';

    public array $filterOptions = [
        'status_id' => -1,
        'group_id' => -1
    ];

    #[Computed]
    public function bots()
    {
        $botBuilder = Bot::with(['status', 'group'])
            ->where('user_id', auth()->id());

        $botBuilder = match ($this->filterOptions['status_id']) {
            -1 => $botBuilder->whereIn('status_id', [2, 3, 4, 5]),
            default => $botBuilder->where('status_id', $this->filterOptions['status_id'])
        };

        if($this->viewType === 'show')
        {
            $botBuilder = match ($this->filterOptions['group_id']) {
                -1 => $botBuilder,
                0 => $botBuilder->where('group_id', null),
                default => $botBuilder->where('group_id', $this->filterOptions['group_id'])
            };
        }
        else if ($this->viewType === 'checkbox') {
            $botBuilder = $botBuilder->where('group_id', $this->filterOptions['group_id'])
                ->orWhere('group_id', null);
        }

        return $botBuilder->get();
    }

    #[On('filter-save')]
    public function setFilterOptions($group_id, $status_id = -1): void
    {
        $this->filterOptions['status_id'] = $status_id;
        $this->filterOptions['group_id'] = $group_id;
    }

    #[On('bot-index:remove-filters')]
    public function resetFilterOptions(): void
    {
        if($this->filterOptions['status_id'] !== -1 OR $this->filterOptions['group_id'] !== -1)
        {
            $this->reset('filterOptions');
            unset($this->bots);
        } else if($this->viewType === 'checkbox')
        {
            $this->reset('viewType');
        }
    }

    #[On('edit-group-members')]
    public function startBotListManagement(int $groupId): void
    {
        $this->addedBotsIds = $this->bots->pluck('id')->toArray();
        $this->selectedBotsIds = $this->addedBotsIds;
        $this->viewType = 'checkbox';
        unset($this->bots);
    }

    public function selectBotForGroup(int $botId): void
    {
        $this->selectedBotsIds[] = $botId;
    }

    public function rejectBotForGroup(int $botId): void
    {
        $key = array_search($botId, $this->selectedBotsIds);
        unset($this->selectedBotsIds[$key]);
    }

    public function saveSelectedGroupBots(): void
    {
        $forDelete = array_diff($this->addedBotsIds, $this->selectedBotsIds);
        $forSave = array_diff($this->selectedBotsIds, $this->addedBotsIds);

        foreach ($this->bots as $bot)
        {
            if(in_array($bot->id, $forDelete)) $bot->update(['group_id' => null]);
            else if(in_array($bot->id, $forSave)) $bot->update(['group_id' => $this->filterOptions['group_id']]);
        }

        $this->reset('viewType', 'selectedBotsIds', 'addedBotsIds');
        unset($this->bots);
    }


    public function render()
    {
        return view('livewire.bot.bot-index', [
            'bots' => $this->bots
        ]);
    }
}

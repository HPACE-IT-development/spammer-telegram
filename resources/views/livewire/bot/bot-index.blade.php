<div class="list-group">
    @foreach($bots as $key => $bot)
        @switch($viewType)
            @case('show')
                <x-bot.item :bot="$bot"/>
                @break
            @case('checkbox')
                <x-bot.item-checkbox :bot="$bot" :selectedBotsIds="$selectedBotsIds" />
                @break
        @endswitch
    @endforeach

    @if($viewType === 'checkbox')
        <div class="btn-group p-4 bg-white position-sticky bottom-0">
            <button
                wire:click="saveSelectedGroupBots"
                class="btn btn-outline-success"
            >Принять</button>
            <button class="btn btn-outline-danger">Отменить</button>
        </div>
    @endif
</div>

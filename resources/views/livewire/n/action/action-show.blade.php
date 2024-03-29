<div>
    <div class="mb-3">
        <div class="row align-items-center">
            <span class="col-3">Получатели:</span>
            <button
                wire:click="toggleVisibleElement('recipients')"
                class="col-8 btn btn-light" type="button"
            >{{($visibleElement === 'recipients')? 'Скрыть': 'Показать'}}</button>
        </div>

        @if($visibleElement === 'recipients')
            <div wire:transition >
                @foreach($action->recipients as $recipient)
                    {{($loop->last)? "$recipient": "$recipient,"}}
                @endforeach
            </div>
        @endif
    </div>

    <div class="mb-3">
        <div class="row align-items-center">
            <span class="col-3">Текст:</span>
            <button
                wire:click="toggleVisibleElement('text')"
                class="col-8 btn btn-light" type="button"
            >{{($visibleElement === 'text')? 'Скрыть': 'Показать'}}</button>
        </div>

        @if($visibleElement === 'text')
            <div wire:transition class="text-break">
                {{$action->text}}
            </div>
        @endif
    </div>

    <div class="mb-3">
        <div class="row align-items-center">
            <span class="col-3">Исполнители:</span>
            <button
                wire:click="toggleVisibleElement('performers')"
                class="col-8 btn btn-light"
            >
                {{($visibleElement === 'performers')? 'Скрыть': 'Показать'}}
            </button>
        </div>

        @if($visibleElement === 'performers')
            <div wire:transition class="w-100">
                <livewire:n.bot.bot-index mode="performers" :action="$action"/>
            </div>
        @endif
    </div>
</div>

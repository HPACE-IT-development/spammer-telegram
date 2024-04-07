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
            <div wire:transition class="mt-2">
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
            <div wire:transition>
                <div class="text-break text-center mt-2">
                    {{$action->text}}
                </div>
                @if(isset($action->first_image_url))
                    <div class="mx-auto mt-2" style="max-width: 480px; max-height: 270px;">
                        <img class="img-fluid h-100" src="{{ $action->first_image_url }}">
                    </div>
                @endif
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

    @if(isset($action))
        @if($action->status->title === 'created')
            <button
                wire:click="performJob"
                type="button"
                class="btn btn-primary btn-sm"
                {{($action->performers->isEmpty())? 'disabled': ''}}
            >Выполнить задачу</button>
        @endif

        <button
            wire:click="deleteAction"
            type="button"
            class="btn btn-danger btn-sm"
        >Удалить задачу</button>
    @endif
</div>

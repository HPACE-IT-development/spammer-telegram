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

    <div class="row mb-3">
        <span class="col-3">Исполнитель: </span>
        <div class="col-6">
            <div class="form-check form-check-inline">
                <input
                    wire:model="senderType"
                    class="form-check-input"
                    id="senderGroupRadio"
                    type="radio"
                    value="group">
                <label class="form-check-label" for="senderGroupRadio">Группа</label>
            </div>

            <div class="form-check form-check-inline">
                <input
                    wire:model="senderType"
                    class="form-check-input"
                    id="senderWithoutGroupRadio"
                    type="radio"
                    value="account"
                >
                <label class="form-check-label" for="senderWithoutGroupRadio">Без группы</label>
            </div>
        </div>
    </div>

    <select class="form-select">

    </select>

</div>

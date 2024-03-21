<div class="container px-5">
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif
    <div class="d-flex justify-content-between px-4 py-3">
        <div>
            <select wire:model.change="botStatusTitleFilter" class="form-select" name="">
                @foreach($filtrationStatuses as $key => $status)
                    <option
                        value="{{$status['title']}}"
                        {{($botStatusTitleFilter === $status['title'])? 'selected': ''}}
                    >{{$status['desc_ru']}}</option>
                @endforeach
            </select>
        </div>
        <div>
            @if($mode === 'simple')
                <button
                    class="btn btn-primary"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#botCreateModal"
                >Добавить аккаунт</button>

                <button
                    wire:click="changeMode('removal')"
                    class="btn btn-danger"
                    type="button"
                >Удалить</button>
            @elseif($mode === 'removal')
                <button wire:click="acceptRemoval" class="btn btn-primary">Сохранить</button>
                <button wire:click="cancelRemoval" class="btn btn-danger">Отменить</button>
            @endif
        </div>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>Номер</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            @foreach($bots as $key => $bot)
                @switch($mode)
                    @case('simple')
                        <x-n.bot.bot-index-simple-item :bot="$bot" :key="$key" />
                        @break
                    @case('removal')
                        <x-n.bot.bot-index-checkbox-item :bot="$bot" :selectedBots="$selectedBots"/>
                        @break
                @endswitch
            @endforeach
        </tbody>
    </table>

    <livewire:n.bot.create.bot-create />
</div>


@script
<script>
    Livewire.hook('morph.added',  ({ el }) => {
        if(el.classList.contains('cell-checkbox')) {
            let botId = el.id.match(/^bot(?<bot_id>[0-9]+)-.*/).groups.bot_id;
            el.addEventListener('click', () => {
                $wire.toggleSelectedBot(botId);
            })
        }
    });
</script>
@endscript

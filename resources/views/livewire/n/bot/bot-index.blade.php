<div wire:key='{{($mode === 'performers')? "$mode-{$action->id}": "single"}}'>
    @if($mode === 'simple' OR $mode === 'removal')
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{session()->get('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif(session()->has('danger'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{session()->get('danger')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between px-4 py-3">
            <div>
                <select wire:model.change="botStatusTitleFilter" class="form-select form-select-sm" name="">
                    @foreach($filtrationStatuses as $key => $status)
                        <option
                            wire:key="{{$status['id']}}"
                            value="{{$status['title']}}"
                            {{($botStatusTitleFilter === $status['title'])? 'selected': ''}}
                        >{{$status['desc_ru']}}</option>
                    @endforeach
                </select>
            </div>

            @if($mode === 'simple')
                <div>
                    <button
                        class="btn btn-primary btn-sm"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#botCreateModal"
                    >Добавить аккаунт
                    </button>

                    <button
                        wire:click="$set('mode', 'removal')"
                        class="btn btn-danger btn-sm"
                        type="button"
                    >Удалить
                    </button>
                </div>
            @elseif($mode === 'removal')
                <div>
                    <button wire:click="acceptRemoval" class="btn btn-primary btn-sm">Сохранить</button>
                    <button wire:click="cancelRemoval" class="btn btn-danger btn-sm">Отменить</button>
                </div>
            @endif
        </div>
    @endif

    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Номер</th>
            <th>Статус</th>
        </tr>
        </thead>

        <tbody>
        @foreach($bots as $key => $bot)
            @switch($mode)
                @case('simple')
                    <x-n.bot.bot-index-simple-item :bot="$bot" :key="$key"/>
                    @break
                @case('removal')
                @case('performers')
                    <x-n.bot.bot-index-checkbox-item :bot="$bot" :selectedBots="$selectedBots"/>
                    @break
            @endswitch
        @endforeach
        </tbody>
    </table>

    <div>
        @if($mode === 'simple')
            <livewire:n.bot.create.bot-create />
        @elseif($mode === 'performers')
    </div>
        <div>
            <button
                {{($isDiffActionPerformersAndSelectedBots)? '': 'disabled'}}
                wire:click="saveSelectedBots"
                type="button"
                class="btn btn-primary btn-sm">Сохранить</button>
            <button
                {{($isDiffActionPerformersAndSelectedBots)? '': 'disabled'}}
                wire:click="cancelSelected"
                type="button"
                class="btn btn-danger btn-sm">Отменить</button>
        </div>
    @endif
</div>

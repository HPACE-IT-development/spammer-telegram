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

        <div class="row pt-5 pb-3 gx-0 justify-content-between">
            <div class="col-5 row gx-1">
                <div class="col">
                    <label for="searchByPhoneNumber" class="form-label">Поиск</label>
                    <input type="text" id="searchByPhoneNumber" class="form-control form-control-sm"
                           placeholder="Номер телефона" wire:model.debounce.300ms="query">
                </div>

                <div class="col">
                    <label for="selectBotStatus" class="form-label">Статус бота</label>
                    <select id="selectBotStatus" wire:model.change="botStatusTitleFilter"
                            class="form-select form-select-sm" name="">
                        @foreach($filtrationStatuses as $key => $status)
                            <option
                                    wire:key="{{$status['id']}}"
                                    value="{{$status['title']}}"
                                    {{($botStatusTitleFilter === $status['title'])? 'selected': ''}}
                            >{{$status['desc_ru']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-3 btn-group h-50 align-self-end">
                @if($mode === 'simple')
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#botCreateModal">Добавить бота
                    </button>
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"></button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" wire:click="$set('mode', 'removal')">Удаление</a></li>
                        <li><a class="dropdown-item">Проверить статусы ботов</a></li>
                    </ul>
                @elseif($mode === 'removal')
                    <button wire:click="acceptRemoval" class="btn btn-primary btn-sm"{{($selectedBotsAmount === 0)? 'disabled': ''}}>Сохранить</button>
                    <button wire:click="cancelRemoval" class="btn btn-danger btn-sm">Отменить</button>
                @endif
            </div>
        </div>
    @endif

    <table class="table table-striped border border-light-subtle" style="border-collapse: collapse;">
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
            <livewire:n.bot.create.bot-create/>
        @elseif($mode === 'performers')
            <button
                    {{($isDiffActionPerformersAndSelectedBots)? '': 'disabled'}}
                    wire:click="saveSelectedBots"
                    type="button"
                    class="btn btn-primary btn-sm">Сохранить
            </button>

            <button
                    {{($isDiffActionPerformersAndSelectedBots)? '': 'disabled'}}
                    wire:click="cancelSelected"
                    type="button"
                    class="btn btn-danger btn-sm">Отменить
            </button>
        @endif
    </div>
</div>

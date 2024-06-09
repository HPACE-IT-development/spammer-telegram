<div>
    <div class="mb-3">
        <h4 class="h4">
            {{$action->type->desc_ru}}
             #{{$action->id}}
             ({{$action->status->description}})
        </h4>
    </div>

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

    @if($action->status->title === 'done')
        <div class="mb-3 mt">
            <div class="row align-items-center">
                <span class="col-3">Отчет:</span>
                <button
                    wire:click="toggleVisibleElement('report')"
                    class="col-8 btn btn-light"
                >
                    {{($visibleElement === 'report')? 'Скрыть': 'Показать'}}
                </button>
            </div>

            @if($visibleElement === 'report')
                <div wire:transition class="mt-4" style="font-size: 0.9em">
                    <div class="row">
                        <div class="col col-3">Начало и Завершение:</div>
                        <div class="col col-8 text-center">{{$action->report->created_at}} <br> {{$action->report->updated_at}}</div>
                    </div>

                    <div class="row mt-2">
                        <div class="col col-3">Статус:</div>
                        <div class="col col-8 text-center">{{$action->report->status->desc_ru}}</div>
                    </div>

                    <div class="row mt-2">
                        <div class="col col-3">Сессии:</div>
                        <div class="col col-8 text-center">
                            @if($action->report->sessions_erros)
                                @foreach($action->report->sessions_erros as $phone => $message)
                                    <div class="d-flex flex-column mt-2 align-items-center" style="font-size: 0.8em;">
                                        <div>{{$phone}}</div>
                                        <div>{{$message}}</div>
                                    </div>
                                @endforeach
                            @else
                                <div>Ошибки отсутствуют</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col col-3">Ошибки получаетелей:</div>
                        <div class="col col-8">
                            @if($action->report->info_about_recipients)
                                @foreach($action->report->info_about_recipients as $recipient => $info)
                                    @if(!$info['sent'])
                                        <div class="d-flex flex-column mt-2 align-items-center" style="font-size: 0.8em;">
                                            <div>{{$recipient}}:</div>
                                            <div>{{$info['message']}}</div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div>Ошибки отсутствуют</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if(!empty($poll) AND $action->report)
        <div wire:poll>
            <div class="progress w-75 mx-auto">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     style="width: {{$action->report->completion_percentage}}%"
                >
                    %{{$action->report->completion_percentage}}
                </div>
            </div>
        </div>
    @endif

    @if(isset($action))
        <div>
            @if($action->status->title === 'created')
                <button
                    wire:click="performJob"
                    type="button"
                    class="btn btn-primary btn-sm"
                    {{($action->performers->isEmpty())? 'disabled': ''}}
                >Выполнить задачу
                </button>
            @endif

            @if($action->status->title === 'created' OR $action->status->title === 'done')
                <div class="btn-group btn-group-sm">
                    <button
                            wire:click="deleteAction"
                            type="button"
                            class="btn btn-danger"
                    >Удалить задачу
                    </button>

                    @if($action->status->title === 'done')
                        <button
                                type="button"
                                class="btn btn-primary ms-1"
                        >Повторить задачу
                        </button>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>

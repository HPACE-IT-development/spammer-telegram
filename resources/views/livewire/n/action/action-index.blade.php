<div class="container p-5">

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{session()->get('success')}}
            <button wire:click="forgetSession(['success'])" type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row pt-5 pb-4 gx-4 justify-content-between">

        <div class="col-7 row gx-1">
            <div class="col-8 row gx-1">
                <label for="searchByPhoneNumber" class="form-label">Поиск</label>
                <div class="col">
                    <input type="text" id="searchByPhoneNumber" class="form-control form-control-sm"
                           placeholder="Номер телефона">
                </div>

                <div class="col">
                    <input type="text" id="searchByPhoneNumber" class="form-control form-control-sm"
                           placeholder="Фрагмент текста рассылки">
                </div>
            </div>

            <div class="col-4">
                <label for="selectBotStatus" class="form-label">Статус задачи</label>
                <select id="selectBotStatus"
                        class="form-select form-select-sm" name="">
                    <option value="0">Любой</option>
                    <option value="1">Создан</option>
                    <option value="2">В очереди</option>
                    <option value="3">В работе</option>
                    <option value="4">Завершён</option>
                </select>
            </div>
        </div>

        <div class="col-2 btn-group h-50 align-self-end">
            <button type="button"
                    class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#actionCreateModal"
            >Добавить задачу
            </button>
        </div>
    </div>

    <div class="row mt-3">
        @if($actions->isNotEmpty())
            <div {{($isThereStatusInQueueOrAtWork)? 'wire:poll': ''}} class="col-4 list-group ps-2">
                @foreach($actions as $collectionKey => $action)
                    <x-n.action.action-index-simple-item
                        wire:click="toggleActiveAction"
                        :action="$action"
                        :collectionKey="$collectionKey"
                        :activeActionId="$activeAction->id"
                    />
                @endforeach
            </div>

            <div class="col-8">
                <livewire:n.action.action-show
                    :action="$activeAction"
                    :key="$activeAction->id.'-'.$isActiveActionStatusAtWork"
                    :poll="$isActiveActionStatusAtWork"
                />
            </div>
        @else
            <div class="text-center pt-5">
                <span>Вы пока не добавили ни одной задачи.</span>
            </div>
        @endif
    </div>

    <livewire:n.action.action-create/>
</div>

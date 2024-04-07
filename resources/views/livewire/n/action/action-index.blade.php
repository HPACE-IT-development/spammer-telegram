<div class="container p-5">

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{session()->get('success')}}
            <button wire:click="forgetSession(['success'])" type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-8">
            Фильтры
        </div>

        <div class="col-4 d-flex justify-content-end">
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

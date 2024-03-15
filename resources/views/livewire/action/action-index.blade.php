<div class="pt-3 h-100">
    <h3 class="h3 text-center">Задачи</h3>

    <form wire:submit="filter" action="">
        <select wire:model="displayedStatus" class="form-select">
            @foreach($statuses as $status)
                <option
                    {{($displayedStatus === $status->title)? 'selected': ''}}
                    value="{{$status->title}}"
                >{{$status->description}}</option>
            @endforeach
        </select>
        <input type="submit" class="form-control" value="Применить">
    </form>

    <div class="{{$actions->isEmpty()? 'position-relative': 'row mt-3'}} h-100">
        @if($actions->isEmpty())
            <span class="fs-3 position-absolute start-50" style="bottom: 65%;">Пусто</span>
        @else
            <div class="col-4 list-group ps-2">
                @foreach($actions as $action)
                    <x-action.action-index-item wire:click="toggleActiveAction" :action="$action" activeActionId="{{$activeAction->id}}"/>
                @endforeach
            </div>

            <div class="col-8">
                @if(!is_null($activeAction))
                    <livewire:action.action-show :action="$activeAction" :key="$activeAction->id" />
                @endif
            </div>
        @endif
    </div>
</div>

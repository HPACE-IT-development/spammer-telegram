<div>
    <h2 class="h2 text-center my-5">Фильтр</h2>
    <form wire:submit="save" action="" class="w-50 mx-auto">
        <div class="mb-3">
            <h5 class="h5">Статус аккаунтов:</h5>
            <select class="form-select" wire:model="selectedStatusId">
                @foreach($statuses as $status)
                    <option wire:key="{{$status['id']}}" value="{{$status['id']}}">{{$status['name']}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <h5 class="h5">Группа:</h5>
            <select class="form-select" wire:model="selectedGroupId">
                @foreach($groups as $group)
                    <option wire:key="{{$group['id']}}" value="{{$group['id']}}">{{$group['name']}}</option>
                @endforeach
            </select>
        </div>

        <input class="form-control btn btn-light" type="submit" value="Применить">
    </form>
</div>

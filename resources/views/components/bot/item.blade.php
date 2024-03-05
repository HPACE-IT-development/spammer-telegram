<a
    wire:click.prevent="showDetails"
    href=""
    class="
        list-group-item
        list-group-item-action
        list-group-item-light
        border-0 rounded-0
        px-4 py-2
    "
>
    <div class="container-fluid p-0 ms-1">
        <div class="d-flex mb-1 justify-content-between align-items-center">
            <h4 class="h4 m-0">{{$bot->phone}}</h4>
            <span class="badge text-bg-{{$bot->status_background}}">
                {{$bot->status_background !== 'light'? $bot->status->description: 'Не определён'}}
            </span>
        </div>

        <div class="d-flex mb-1">
            <i class="bi bi-collection-fill"></i>
            <h6 class="h6 m-0 ms-1 align-self-end">{{!is_null($bot->group)? $bot->group->name: 'Без группы'}}</h6>
        </div>

        <div class="d-flex">

            <h6 class="h6 m-0 ms-1 align-self-end">{{!is_null($bot->name)? $bot->name: 'Без имени'}}</h6>
        </div>
    </div>
</a>

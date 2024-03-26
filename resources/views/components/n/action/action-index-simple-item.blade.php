<button
    wire:key="{{$action->id}}"
    wire:click="toggleActiveAction({{$collectionKey}})"
    class="
        list-group-item
        list-group-item-action
        list-group-item-{{$action->status_background}}
        {{($action->id === $activeActionId)? 'active': ''}}
    "
    {{($action->id === $activeActionId)? 'disabled': ''}}
>
    <span>
        {{$action->type->desc_ru}}: {{$action->created_at}}
    </span>
</button>

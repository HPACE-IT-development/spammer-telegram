<button
    wire.key="{{$action->id}}"
    wire:click="toggleActiveAction({{$action->id}})"
    class="
        list-group-item
        list-group-item-action
        {{($action->status->title === 'created')? 'list-group-item-primary ': ''}}
        {{($action->status->title === 'at work')? 'list-group-item-warning ': ''}}
        {{($action->status->title === 'success')? 'list-group-item-success ': ''}}
        {{($action->status->title === 'fail')? 'list-group-item-danger ': ''}}
        {{($action->id === (int) $activeActionId)? 'active': ''}}
    "
>
    <span>
        {{$action->type->description}}: {{$action->created_at}}
    </span>
</button>

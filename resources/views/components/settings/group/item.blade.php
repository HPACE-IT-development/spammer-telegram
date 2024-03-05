<a
    wire:key="{{$group->id}}"
    wire:click.prevent="setActivePane('details', {{$groupKey}})"
    href="#settings-group-{{$group->id}}-content"
    class="
        list-group-item
        list-group-item-action
        d-flex
        justify-content-between
        align-items-start
        {{($groupKey === $activeGroupKey)? 'active ': ''}}
        {{$loop->first? 'border-top': ''}}
    "
>
    <div class="fs-8" style="font-size: 0.9rem;">{{$group->name}}</div>
    <span class="badge text-bg-secondary rounded-pill">10</span>
</a>

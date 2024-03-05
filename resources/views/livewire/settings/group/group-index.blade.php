<div class="flex-grow-1">
    <h3 class="text-center h3 mb-5">Управление группами</h3>

    <div class="row gx-0">
        <div class="col-4">
            <ul class="list-group">
                <a
                    wire:click.prevent="setActivePane('create')"
                    href=""
                    class="
                        list-group-item
                        list-group-item-action
                        fw-bold
                        mb-3
                        rounded-0
                        {{($this->activePane === 'create')? 'active': ''}}
                    "
                >
                    Создать группу
                </a>

                @foreach($groups as $key => $group)
                    <x-settings.group.item
                        :groupKey="$key"
                        :activeGroupKey="$activeGroupKey"
                        :group="$group"
                        :loop="$loop"
                    />
                @endforeach
            </ul>
        </div>
        <div class="col-8">
            @switch($this->activePane)
                @case('create')
                    <livewire:settings.group.group-create />
                    @break
                @case('details')
                    <livewire:settings.group.group-show  :groups="$groups" :activeGroupKey="$activeGroupKey"/>
                    @break
            @endswitch
        </div>
    </div>
</div>

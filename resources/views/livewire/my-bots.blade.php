<div class="row h-100 justify-content-center">
    <div class="col-3 h-100 p-0 overflow-auto">
        <x-my-bots-nav :links="$panes" :activeLink="$activePane"/>
        <livewire:bot.bot-index />
    </div>

    <div class="col-6">
        @switch($activePane)
            @case('create')
                <livewire:bot.bot-create />
            @break

            @case('settings')
                <livewire:bot.settings />
            @break
        @endswitch
    </div>
</div>

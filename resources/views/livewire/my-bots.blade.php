<div class="container mx-auto pt-3 row h-100">
    <div class="col-4 h-100 p-0 overflow-auto">
        <x-my-bots-nav :links="$panes" :activeLink="$activePane"/>
        <livewire:bot.bot-index />
    </div>

    <div class="col-8">
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

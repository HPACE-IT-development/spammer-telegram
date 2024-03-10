<div wire:transition class="mt-3 d-flex justify-content-between">
    @switch($activeSettingsItem)
        @case('groups')
            <livewire:settings.group.group-index />
            @break

        @case('item2')
            item2
            @break

        @case('item3')
            item3
            @break
    @endswitch

    <x-settings.nav :items="$settingsItems" :activeItem="$activeSettingsItem"/>
</divwire:transition>

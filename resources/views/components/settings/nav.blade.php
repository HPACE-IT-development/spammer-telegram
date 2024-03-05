<ul class="nav nav-pills flex-column align-items-end">
    @foreach($items as $key => $item)
        <li
            wire:click="changeActiveItem('{{$key}}')"
            wire:key="{{$key}}"
            class="nav-item"
        >
            <button class="nav-link {{($key === $activeItem)? 'active': ''}}">{{$item}}</button>
        </li>
    @endforeach
</ul>

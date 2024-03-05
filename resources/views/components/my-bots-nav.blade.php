<ul class="nav nav-justified align-items-center pt-2 pb-3 px-4">
    @foreach($links as $key => $link)
        <li
            wire:key="{{$key}}"
            wire:click.prevent="showPane('{{$key}}')"
            class="nav-item"
        >
            <a
                class="nav-link {{($key === $activeLink)? 'link-dark': 'link-secondary'}}"
                href=""
            >{{$link}}</a>
        </li>
    @endforeach
</ul>

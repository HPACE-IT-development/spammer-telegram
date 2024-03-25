<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }}</title>
    <livewire:scripts/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="">
<header>
    <div class="navbar navbar-expand bg-body-tertiary py-3">
        <div class="container">
            <span class="navbar-brand h1 fs-2 m-0">HPACE</span>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a wire:navigate href="{{action(\App\Livewire\N\Bots::class)}}" class="nav-link">Боты</a>
                </li>

                <li class="nav-item">
                    <a wire:navigate href="{{action(\App\Livewire\N\Action\ActionIndex::class)}}" class="nav-link">Задачи</a>
                </li>
            </ul>
        </div>
    </div>
</header>

<main class="container">
    {{ $slot }}
</main>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>{{ $title ?? 'Page Title' }}</title>
</head>
<body class="">
<header>
    <div class="navbar navbar-expand bg-body-tertiary py-3">
        <div class="container">
            <span class="navbar-brand h1 fs-2 m-0">HPACE</span>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a wire:navigate href="{{action(\App\Livewire\N\Bot\BotIndex::class)}}" class="nav-link">Боты</a>
                </li>

                <li class="nav-item">
                    <a wire:navigate href="{{action(\App\Livewire\Newsletter::class)}}" class="nav-link">Задачи</a>
                </li>
            </ul>
        </div>
    </div>
</header>

<main class="container">
    {{ $slot }}
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

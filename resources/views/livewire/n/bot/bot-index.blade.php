<div class="container px-5">
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif
    <div class="d-flex justify-content-between px-4 py-3">
        <div>Здесь фильтры</div>
        <button
            class="btn btn-primary"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#botCreateModal"
        >Добавить аккаунт</button>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>Номер</th>
                <th>Статус</th>
            </tr>
        </thead>

        <tbody>
            @foreach($bots as $key => $bot)
                    <tr class="table-{{$bot->status_background}}">
                        <td>{{$key}}</td>
                        <td>{{isset($bot->name)? $bot->name: 'Не указано'}}</td>
                        <td>{{$bot->phone}}</td>
                        <td>{{$bot->status->description}}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>

    <livewire:n.bot.create.bot-create />
</div>

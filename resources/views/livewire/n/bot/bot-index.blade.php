<div class="container px-5">
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
</div>

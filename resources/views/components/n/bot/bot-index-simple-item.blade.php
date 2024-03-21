<tr wire:key="simple-{{$key}}" class="table-{{$bot->status_background}}">
    <td>{{$key}}</td>
    <td>{{isset($bot->name)? $bot->name: 'Не указано'}}</td>
    <td>{{$bot->phone}}</td>
    <td>{{$bot->status->desc_ru}}</td>
    <td></td>
</tr>

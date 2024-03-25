<tr wire:key="simple-{{$key + 1}}" class="table-{{$bot->status_background}}">
    <td>{{$key + 1}}</td>
    <td>{{$bot->phone}}</td>
    <td>{{$bot->status->desc_ru}}</td>
    <td>
        <button wire:click="destroyBot({{$bot->id}})" class="btn btn-outline-{{$bot->status_background}} btn-sm">Удалить</button>
    </td>
</tr>

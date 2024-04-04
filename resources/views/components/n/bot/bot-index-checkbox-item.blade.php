<tr
    wire:click="toggleSelectedBot('{{$bot->id}}}')"
    wire:key="checkbox-{{$bot->id}}"
    class="table-{{$bot->status_background}} cell-checkbox">
    <td>
        <input class="form-check-input" type="checkbox" {{(in_array($bot->id, $selectedBots))? 'checked': ''}}/>
    </td>
    <td>{{$bot->phone}}</td>
    <td>{{$bot->status->desc_ru}}</td>
    <td></td>
</tr>

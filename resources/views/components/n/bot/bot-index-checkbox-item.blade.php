<tr id="bot{{$bot->id}}-cellCheckbox" wire:key="checkbox-{{$bot->id}}" class="table-{{$bot->status_background}} cell-checkbox">
    <td>
        <input class="form-check-input" type="checkbox" {{(in_array($bot->id, $selectedBots))? 'checked': ''}}/>
    </td>
    <td>{{isset($bot->name)? $bot->name: 'Не указано'}}</td>
    <td>{{$bot->phone}}</td>
    <td>{{$bot->status->desc_ru}}</td>
    <td></td>
</tr>

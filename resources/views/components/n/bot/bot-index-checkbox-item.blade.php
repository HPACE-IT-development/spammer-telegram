<?php

use App\Enums\BotStatusesEnum;

?>
<tr
    wire:click="toggleSelectedBot('{{$bot->id}}}')"
    wire:key="checkbox-{{$bot->id}}"
    class="cell-checkbox">
    <td>
        <input class="form-check-input" type="checkbox" {{(in_array($bot->id, $selectedBots))? 'checked': ''}}/>
    </td>
    <td>{{$bot->phone}}</td>
    <td>
        <span class="d-inline-block p-2 text-center py-1 rounded-5"
              style="background-color: {{BotStatusesEnum::getFriendlyStatusForBackground($bot->status_id)}}; color: {{BotStatusesEnum::getFriendlyStatusForColor($bot->status_id)}}; font-size: 14px; width: 100px;">
            {{$bot->status->desc_ru}}
        </span>
    </td>
    <td></td>
</tr>

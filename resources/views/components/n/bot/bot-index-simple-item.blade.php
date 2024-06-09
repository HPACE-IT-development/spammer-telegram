<?php

use App\Enums\BotStatusesEnum;

?>
<tr wire:key="simple-{{$key + 1}}">
    <td>{{$key + 1}}</td>
    <td>{{$bot->phone}}</td>
    <td>
        <span class="d-inline-block p-2 text-center py-1 rounded-5"
           style="background-color: {{BotStatusesEnum::getFriendlyStatusForBackground($bot->status_id)}}; color: {{BotStatusesEnum::getFriendlyStatusForColor($bot->status_id)}}; font-size: 14px; width: 100px;">
            {{$bot->status->desc_ru}}
        </span>
    </td>
    <td>
        <button wire:click="destroyBot({{$bot->id}})" class="btn btn-outline-danger btn-sm">
            Удалить
        </button>
    </td>
</tr>

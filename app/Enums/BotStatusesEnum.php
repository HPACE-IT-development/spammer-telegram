<?php

namespace App\Enums;

enum BotStatusesEnum: int
{
    case ACTIVE = 2;
    case IN_WORK = 3;
    case INACTIVE = 4;


    public static function getFriendlyStatusForBackground(int $value)
    {
        $array = [
            self::ACTIVE->value => '#249103',
            self::IN_WORK->value => '#ADA305',
            self::INACTIVE->value => '#BA340D',
        ];

        return $array[$value];
    }

    public static function getFriendlyStatusForColor(int $value)
    {
        $array = [
            self::ACTIVE->value => '#4EF91A',
            self::IN_WORK->value => '#F6E709',
            self::INACTIVE->value => '#FF7247'
        ];

        return $array[$value];
    }
}
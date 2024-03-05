<?php

namespace App\Enums;

use danog\MadelineProto\API;

enum TelegramAuthStatusEnum: int
{
    case NOT_LOGGED_IN = API::NOT_LOGGED_IN;
    case WAITING_CODE = API::WAITING_CODE;
    case WAITING_SIGNUP = API::WAITING_SIGNUP;
    case WAITING_PASSWORD = API::WAITING_PASSWORD;
    case LOGGED_IN = API::LOGGED_IN;
    case LOGGED_OUT = API::LOGGED_OUT;
}

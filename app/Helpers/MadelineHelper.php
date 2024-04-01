<?php

namespace App\Helpers;

use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use Illuminate\Support\Facades\Storage;

class MadelineHelper
{
    public static function getMadelineSettings(): Settings
    {
        $settings = new Settings();
        $settings->setAppInfo((new AppInfo())
            ->setApiId(20984257)
            ->setApiHash('03a687e8d76365950f7797a2d4e5f8cf')
        );
        return $settings;
    }

    public static function getMadelinePath(string $phone): string
    {
        return 'storage/sessions/' . str_replace('+', '', $phone) . '.madeline';
    }

    public static function getMadelineFullPath(string $phone): string
    {
        return Storage::path('sessions').'/'.str_replace('+', '', $phone) . '.madeline';
    }

//    public static function getMadelineStoragePath(string $phone): string
//    {
//        return app()->storagePath('app/public') . '/sessions/' . str_replace('+', '', $phone) . '.madeline';
//    }
}

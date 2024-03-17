<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BotStatusSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('bot_statuses')->insert([
            [
                'title' => 'new',
                'importance' => 0,
                'desc_ru' => 'Новый'
            ],

            [
                'title' => 'active',
                'importance' => 1,
                'desc_ru' => 'Активный'
            ],

            [
                'title' => 'in work',
                'importance' => 2,
                'desc_ru' => 'В работе'
            ],

            [
                'title' => 'inactive',
                'importance' => 3,
                'desc_ru' => 'Неактивный'
            ],
        ]);
    }
}

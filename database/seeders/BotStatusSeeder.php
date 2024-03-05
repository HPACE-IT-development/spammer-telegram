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
                'name' => 'Новый',
                'description' => 'Новый'
            ],

            [
                'name' => 'Активный',
                'description' => 'Активный'
            ],

            [
                'name' => 'Неактивный',
                'description' => 'Неактивный'
            ],

            [
                'name' => 'В работе',
                'description' => 'В работе'
            ],

            [
                'name' => 'Заблокирован',
                'description' => 'Заблокирован'
            ]
        ]);
    }
}

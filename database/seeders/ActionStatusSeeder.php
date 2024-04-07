<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('action_statuses')->insert([
            [
                'title' => 'created',
                'description' => 'Создана'
            ],

            [
                'title' => 'in queue',
                'description' => 'В очереди'
            ],

            [
                'title' => 'at work',
                'description' => 'В работе'
            ],
            [
                'title' => 'done',
                'description' => 'Заверешена'
            ],
        ]);
    }
}

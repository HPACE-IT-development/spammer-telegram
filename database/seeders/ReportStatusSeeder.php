<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('report_statuses')->insert([
            [
                'title' => 'success',
                'desc_ru' => 'Выполнена успешно'
            ],

            [
                'title' => 'danger',
                'desc_ru' => 'Выполнение задачи провалено'
            ]

        ]);
    }
}

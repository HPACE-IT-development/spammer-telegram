<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(1)->create();

         $this->call([
             BotStatusSeeder::class,
             ActionTypeSeeder::class,
             ActionStatusSeeder::class,
             ReportStatusSeeder::class
         ]);

         \App\Models\Bot::factory(6)->create();
//         \App\Models\BotGroup::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

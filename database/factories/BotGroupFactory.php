<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BotGroupFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'name' => $this->faker->realText(maxNbChars: 32),
            'description' => $this->faker->realText(maxNbChars: 255)
        ];
    }
}

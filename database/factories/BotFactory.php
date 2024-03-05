<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bot>
 */
class BotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'phone' => $this->faker->e164PhoneNumber(),
            'status_id' => $this->faker->randomElement([2, 3, 4, 5]),
        ];
    }
}

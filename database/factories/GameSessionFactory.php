<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameSession>
 */
class GameSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'score' => $this->faker->numberBetween(0, 1000),
            'attempts_left' => $this->faker->numberBetween(1, 5),
            'lives' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['in_progress', 'finished']),
        ];
    }
}

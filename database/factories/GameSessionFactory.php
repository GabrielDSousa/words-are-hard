<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Word;
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
            'word_id' => Word::factory(),
            'round' => $this->faker->numberBetween(0, 100),
            'score' => $this->faker->numberBetween(0, 1000),
            'max_attempts' => 5,
            'max_lives' => 5,
            'attempts_left' => $this->faker->numberBetween(1, 5),
            'lives' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['in_progress', 'finished']),
        ];
    }
}

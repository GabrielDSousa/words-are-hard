<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Word>
 */
class WordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->word(),
            'difficulty' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'points' => $this->faker->numberBetween(10, 10000)
        ];
    }
}

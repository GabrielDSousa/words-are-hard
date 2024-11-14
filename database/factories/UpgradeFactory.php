<?php

namespace Database\Factories;

use App\Models\GameSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Upgrade>
 */
class UpgradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_session_id' => GameSession::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'effect' => json_encode($this->faker->text()),
            'isActive' => $this->faker->boolean(),
        ];
    }
}

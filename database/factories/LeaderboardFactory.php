<?php

namespace Database\Factories;

use App\Models\GameSession;
use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaderboardFactory extends Factory
{
    protected $model = Leaderboard::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'score' => $this->faker->numberBetween(100, 5000)
        ];
    }
}

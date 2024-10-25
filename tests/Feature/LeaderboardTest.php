<?php

use App\Models\User;
use App\Models\Leaderboard;

test('creates a Leaderboard with default values', function () {
    // Assumes a user exists or creates one to link to the GameSession
    $user = User::factory()->create();

    // Creates a new leaderboard entry for the user
    $leaderboard = Leaderboard::create([
        'user_id' => $user->id,
        'score' => 3154
    ]);

    // Checks if the Leaderboard was created correctly
    expect($leaderboard)->toBeInstanceOf(Leaderboard::class);
    expect($leaderboard->user_id)->toBe($user->id);
    expect($leaderboard->score)->toBe(3154);
});

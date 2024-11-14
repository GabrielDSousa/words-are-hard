<?php

use App\Models\User;
use App\Models\Leaderboard;

test('creates a Leaderboard with default values and verifies user relationship', function () {
    // Creates a user for the leaderboard entry
    $user = User::factory()->create();

    // Creates a leaderboard entry
    $leaderboard = Leaderboard::create([
        'user_id' => $user->id,
        'score' => 3154
    ]);

    // Asserts that the leaderboard instance is created with expected values
    expect($leaderboard)->toBeInstanceOf(Leaderboard::class);
    expect($leaderboard->user_id)->toBe($user->id);
    expect($leaderboard->score)->toBe(3154);

    // Asserts that the user relation returns the correct User instance
    expect($leaderboard->user)->toBeInstanceOf(User::class);
    expect($leaderboard->user->id)->toBe($user->id);
});

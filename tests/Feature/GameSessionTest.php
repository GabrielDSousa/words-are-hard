<?php

use App\Models\User;
use App\Models\GameSession;

test('creates a GameSession with default values', function () {
    // Assumes a user exists or creates one to link to the GameSession
    $user = User::factory()->create();

    // Creates a new game session for the user
    $gameSession = GameSession::create([
        'user_id' => $user->id,
        'score' => 0,
        'attempts_left' => 5,
        'lives' => 3,
        'status' => 'in_progress',
    ]);

    // Checks if the GameSession was created correctly
    expect($gameSession)->toBeInstanceOf(GameSession::class);
    expect($gameSession->user_id)->toBe($user->id);
    expect($gameSession->score)->toBe(0);
    expect($gameSession->attempts_left)->toBe(5);
    expect($gameSession->lives)->toBe(3);
    expect($gameSession->status)->toBe('in_progress');
});

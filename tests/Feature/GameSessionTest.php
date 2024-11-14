<?php

use App\Models\User;
use App\Models\GameSession;
use App\Models\Word;
use App\Models\Upgrade;

test('creates a GameSession with default values', function () {
    // Assumes a user exists or creates one to link to the GameSession
    $user = User::factory()->create();

    // Assumes a word exists or creates one to link to the GameSession
    $word = Word::factory()->create();

    // Creates a new game session for the user
    $gameSession = GameSession::create([
        'user_id' => $user->id,
        'word_id' => $word->id,
        'round' => 0,
        'score' => 0,
        'max_attempts' => 5,
        'max_lives' => 3,
        'attempts_left' => 5,
        'lives' => 3,
        'status' => 'in_progress',
    ]);

    // Checks if the GameSession was created correctly with default values
    expect($gameSession)->toBeInstanceOf(GameSession::class);
    expect($gameSession->user_id)->toBe($user->id);
    expect($gameSession->word_id)->toBe($word->id);
    expect($gameSession->round)->toBe(0);
    expect($gameSession->score)->toBe(0);
    expect($gameSession->max_attempts)->toBe(5);
    expect($gameSession->max_lives)->toBe(3);
    expect($gameSession->attempts_left)->toBe(5);
    expect($gameSession->lives)->toBe(3);
    expect($gameSession->status)->toBe('in_progress');
});

test('associates with User, Word, and Upgrades', function () {
    $user = User::factory()->create();
    $word = Word::factory()->create();
    $gameSession = GameSession::factory()->create([
        'user_id' => $user->id,
        'word_id' => $word->id,
    ]);
    $upgrade = Upgrade::factory()->create(['game_session_id' => $gameSession->id]);

    expect($gameSession->user)->toBeInstanceOf(User::class);
    expect($gameSession->word)->toBeInstanceOf(Word::class);
    expect($gameSession->upgrade->first())->toBeInstanceOf(Upgrade::class);
});

test('heals GameSession without exceeding max lives', function () {
    $gameSession = GameSession::factory()->create(['lives' => 1, 'max_lives' => 3]);

    $gameSession->heal(1);
    expect($gameSession->lives)->toBe(2);

    $gameSession->heal(2);
    expect($gameSession->lives)->toBe(3); // Cannot exceed max_lives
});

test('damages GameSession without going below zero lives', function () {
    $gameSession = GameSession::factory()->create(['lives' => 3]);

    $gameSession->damage(1);
    expect($gameSession->lives)->toBe(2);

    $gameSession->damage(3);
    expect($gameSession->lives)->toBe(0);
    expect($gameSession->status)->toBe('finished'); // Calls gameOver if lives reach zero
});

test('recharges GameSession without exceeding max attempts', function () {
    $gameSession = GameSession::factory()->create(['attempts_left' => 2, 'max_attempts' => 5]);

    $gameSession->recharge(2);
    expect($gameSession->attempts_left)->toBe(4);

    $gameSession->recharge(2);
    expect($gameSession->attempts_left)->toBe(5); // Cannot exceed max_attempts
});

test('discharges GameSession attempts without going below zero', function () {
    $gameSession = GameSession::factory()->create(['attempts_left' => 3, 'lives' => 2]);

    $gameSession->discharge(1);
    expect($gameSession->attempts_left)->toBe(2);

    $gameSession->discharge(3);
    expect($gameSession->attempts_left)->toBe(0);
    expect($gameSession->lives)->toBe(1); // Calls damage if attempts reach zero
});

test('gameOver sets GameSession to finished state', function () {
    $gameSession = GameSession::factory()->create([
        'attempts_left' => 2,
        'lives' => 1,
        'status' => 'in_progress',
    ]);

    $gameSession->gameOver();

    expect($gameSession->attempts_left)->toBe(0);
    expect($gameSession->lives)->toBe(0);
    expect($gameSession->status)->toBe('finished');
});

test('allStatusCorrect returns true only if all items have correct status', function () {
    $gameSession = new GameSession();
    $correctCollection = collect([['status' => 'correct'], ['status' => 'correct']]);
    $mixedCollection = collect([['status' => 'correct'], ['status' => 'incorrect']]);

    expect($gameSession->allStatusCorrect($correctCollection))->toBeTrue();
    expect($gameSession->allStatusCorrect($mixedCollection))->toBeFalse();
});

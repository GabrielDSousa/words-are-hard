<?php

use App\Models\GameSession;
use App\Models\Upgrade;
use App\Models\User;
use App\Models\Word;

test('associates with User, Word, and Upgrades', function () {
    $user = User::factory()->create();
    $word = Word::factory()->create();
    $gameSession = GameSession::factory()->create([
        'user_id' => $user->id,
        'word_id' => $word->id,
    ]);
    $upgrade = Upgrade::factory()->create(['game_session_id' => $gameSession->id]);

    expect($gameSession->user)->toBeInstanceOf(User::class);
    expect($user->games()->count())->toBe(1);
    expect($user->games()->first())->toBeInstanceOf(GameSession::class);
});

<?php

use App\Models\GameSession;
use App\Models\Upgrade;

test('creates an Upgrade with default values and checks gameSession relationship and activate method', function () {
    // Creates a GameSession instance for the upgrade
    $gameSession = GameSession::factory()->create(['lives' => 1, 'max_lives' => 3]);

    // Creates a new Upgrade instance with an effect to heal
    $upgrade = Upgrade::create([
        'game_session_id' => $gameSession->id,
        'name' => 'example',
        'description' => 'this is an example of upgrade',
        'effect' => json_encode(["effect" => "heal", "value" => 1]),
        'isActive' => false
    ]);

    // Checks if the Upgrade was created correctly
    expect($upgrade)->toBeInstanceOf(Upgrade::class);
    expect($upgrade->name)->toBe('example');
    expect($upgrade->description)->toBe('this is an example of upgrade');
    expect($upgrade->effect)->toBe(json_encode(["effect" => "heal", "value" => 1]));
    expect($upgrade->isActive)->toBe(false);

    // Verifies the gameSession relationship
    expect($upgrade->gameSession)->toBeInstanceOf(GameSession::class);
    expect($upgrade->gameSession->id)->toBe($gameSession->id);

    // Activates the upgrade and checks if the heal effect is applied
    $upgrade->activate();
    $gameSession->refresh(); // Refresh to get updated values from the database

    // Checks if the heal effect was applied correctly
    expect($upgrade->gameSession->lives)->toBe(2); // Initially 1, should increment by 1
});

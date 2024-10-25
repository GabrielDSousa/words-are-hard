<?php

use App\Models\Upgrade;

test('creates a Upgrade with default values', function () {
    // Creates a new game session for the user
    $upgrade = Upgrade::create([
        'name' => 'example',
        'description' => 'this is a example of upgrade',
        'effect' => json_encode(["lives" => 1])
    ]);

    // Checks if the Upgrade was created correctly
    expect($upgrade)->toBeInstanceOf(Upgrade::class);
    expect($upgrade->name)->toBe('example');
    expect($upgrade->description)->toBe('this is a example of upgrade');
    expect($upgrade->effect)->toBe(json_encode(["lives" => 1]));
});

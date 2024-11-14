<?php

use App\Models\Word;

test('creates a Word with default values', function () {
    // Creates a new word
    $word = Word::create([
        'text' => 'FASTER',
        'frequency' => '6.83',
        'info' => json_encode(['foo' => 'bar'])
    ]);

    // Checks if the Word was created correctly
    expect($word)->toBeInstanceOf(Word::class);
    expect($word->text)->toBe('FASTER');
    expect($word->frequency)->toBe('6.83');
    expect($word->info)->toBe(json_encode(['foo' => 'bar']));
});


test('compares words and receives feedback with the result of each letter comparison', function () {
    // Create a new word instance
    $word = Word::create([
        'text' => 'TESTS',
        'frequency' => '6.83',
        'info' => json_encode(['foo' => 'bar'])
    ]);

    // Assert the Word instance was created correctly
    expect($word)->toBeInstanceOf(Word::class);

    // Expected result of comparison
    $expectedResult = collect([
        collect([
            'position' => 0,
            'letter' => 'T',
            'status' => 'correct',
        ]),
        collect([
            'position' => 1,
            'letter' => 'A',
            'status' => 'incorrect',
        ]),
        collect([
            'position' => 2,
            'letter' => 'S',
            'status' => 'correct',
        ]),
        collect([
            'position' => 3,
            'letter' => 'T',
            'status' => 'correct',
        ]),
        collect([
            'position' => 4,
            'letter' => 'E',
            'status' => 'almost',
        ]),
    ]);

    // Compare and assert that the result matches the expected result
    expect($word->compareWord('TASTE'))->toEqual($expectedResult);
});


test('compares words and receives feedback looking for the correct ones first and afetr looking for almost respecting the quantity of the same letter in te word', function () {
    // Create a new word instance
    $word = Word::create([
        'text' => 'FASTER',
        'frequency' => '6.83',
        'info' => json_encode(['foo' => 'bar'])
    ]);

    // Assert the Word instance was created correctly
    expect($word)->toBeInstanceOf(Word::class);

    // Expected result of comparison
    $expectedResult = collect([
        collect([
            'position' => 0,
            'letter' => 'L',
            'status' => 'incorrect',
        ]),
        collect([
            'position' => 1,
            'letter' => 'E',
            'status' => 'incorrect',
        ]),
        collect([
            'position' => 2,
            'letter' => 'T',
            'status' => 'incorrect',
        ]),
        collect([
            'position' => 3,
            'letter' => 'T',
            'status' => 'correct',
        ]),
        collect([
            'position' => 4,
            'letter' => 'E',
            'status' => 'correct',
        ]),
        collect([
            'position' => 5,
            'letter' => 'R',
            'status' => 'correct',
        ]),
    ]);

    // Compare and assert that the result matches the expected result
    expect($word->compareWord('LETTER'))->toEqual($expectedResult);
});

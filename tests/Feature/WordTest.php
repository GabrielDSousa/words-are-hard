<?php

use App\Models\Word;

test('creates a Word with default values', function () {
    // Creates a new word
    $word = Word::create([
        'text' => 'example',
        'difficulty' => 'easy',
        'points' => 100,
        'partOfSpeech' => 'noun',
        'definition' => 'a representative form or pattern'
    ]);

    // Checks if the Word was created correctly
    expect($word)->toBeInstanceOf(Word::class);
    expect($word->text)->toBe('example');
    expect($word->difficulty)->toBe('easy');
    expect($word->points)->toBe(100);
    expect($word->partOfSpeech)->toBe('noun');
    expect($word->definition)->toBe('a representative form or pattern');
    expect($word->points)->toBe(100);
});

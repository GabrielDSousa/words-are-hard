<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordSeeder extends Seeder
{
    public function run()
    {
        $words = [
            [
                'text' => 'apple',
                'difficulty' => 'easy',
                'points' => 10,
                'partOfSpeech' => 'noun',
                'definition' => 'A fruit with a crisp, juicy interior and sweet or tart flavor.',
            ],
            [
                'text' => 'storm',
                'difficulty' => 'medium',
                'points' => 20,
                'partOfSpeech' => 'noun',
                'definition' => 'A severe weather condition with strong winds and rain.',
            ],
            [
                'text' => 'wander',
                'difficulty' => 'medium',
                'points' => 20,
                'partOfSpeech' => 'verb',
                'definition' => 'To move about aimlessly or without a fixed course.',
            ],
            [
                'text' => 'mystery',
                'difficulty' => 'hard',
                'points' => 30,
                'partOfSpeech' => 'noun',
                'definition' => 'Something that is difficult or impossible to understand or explain.',
            ],
            [
                'text' => 'glance',
                'difficulty' => 'easy',
                'points' => 10,
                'partOfSpeech' => 'verb',
                'definition' => 'To take a quick or brief look.',
            ],
            [
                'text' => 'bravery',
                'difficulty' => 'medium',
                'points' => 20,
                'partOfSpeech' => 'noun',
                'definition' => 'Courageous behavior or character.',
            ],
            [
                'text' => 'whisper',
                'difficulty' => 'medium',
                'points' => 20,
                'partOfSpeech' => 'verb',
                'definition' => 'To speak very softly.',
            ],
            [
                'text' => 'echo',
                'difficulty' => 'easy',
                'points' => 10,
                'partOfSpeech' => 'noun',
                'definition' => 'A sound or series of sounds caused by the reflection of sound waves.',
            ],
            [
                'text' => 'wilderness',
                'difficulty' => 'hard',
                'points' => 30,
                'partOfSpeech' => 'noun',
                'definition' => 'An area where there are few people and nature remains untouched.',
            ],
            [
                'text' => 'ignite',
                'difficulty' => 'medium',
                'points' => 20,
                'partOfSpeech' => 'verb',
                'definition' => 'To set on fire or cause to burn.',
            ],
            [
                'text' => 'journey',
                'difficulty' => 'medium',
                'points' => 20,
                'partOfSpeech' => 'noun',
                'definition' => 'A long trip or experience that takes time and effort.',
            ],
            [
                'text' => 'solitude',
                'difficulty' => 'hard',
                'points' => 30,
                'partOfSpeech' => 'noun',
                'definition' => 'The state of being alone, often peacefully.',
            ],
            [
                'text' => 'abundance',
                'difficulty' => 'hard',
                'points' => 30,
                'partOfSpeech' => 'noun',
                'definition' => 'A large quantity of something, more than enough.',
            ],
            [
                'text' => 'delicate',
                'difficulty' => 'medium',
                'points' => 20,
                'partOfSpeech' => 'adjective',
                'definition' => 'Easily broken or damaged; fragile.',
            ],
            [
                'text' => 'whimsy',
                'difficulty' => 'hard',
                'points' => 30,
                'partOfSpeech' => 'noun',
                'definition' => 'Playful or fanciful behavior or ideas.',
            ],
        ];

        foreach ($words as $word) {
            DB::table('words')->insert([
                'text' => $word['text'],
                'difficulty' => $word['difficulty'],
                'points' => $word['points'],
                'definition' => $word['definition'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

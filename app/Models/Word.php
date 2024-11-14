<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Word extends Model
{
    /** @use HasFactory<\Database\Factories\WordFactory> */
    use HasFactory;

    protected $fillable = [
        'text',
        'frequency',
        'info'
    ];


    // Function to compare guessed word with the target word and return "correct" and "misplaced" letters
    function compareWord($guess): Collection
    {
        $guessCollection = collect(str_split($guess));
        $expectedCollection = collect(str_split(strtoupper($this->text)));
        $result = collect([]);

        foreach ($guessCollection as $key => $letter) {
            $feedback = ['position' => $key, 'letter' => $letter];
            $status = 'incorrect';

            if ($expectedCollection->contains($letter) && $expectedCollection->get($key) === $letter) {
                $status = 'correct';
                $expectedCollection->pull($key);
            }

            $feedback['status'] = $status;
            $result->push(collect($feedback));
        }

        foreach ($guessCollection as $key => $letter) {
            $feedback = $result->pull($key);
            $status = 'incorrect';

            if ($feedback->get('status') !== 'correct' && $expectedCollection->contains($letter)) {
                $feedback->pull('status');
                $feedback->put('status', 'almost');
                $expectedCollection->pull($key);
            }

            $result->put($key, $feedback);
        }

        return $result;
    }
}

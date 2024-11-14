<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameSession extends Model
{
    /** @use HasFactory<\Database\Factories\GameSession> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'word_id',
        'round',
        'score',
        'max_attempts',
        'max_lives',
        'attempts_left',
        'lives',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'word_id'
    ];

    /**
     * Define User relation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define Word relation.
     */
    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }

    /**
     * Define Upgrade relation.
     */
    public function upgrade(): HasMany
    {
        return $this->hasMany(Upgrade::class);
    }

    /**
     * Give one or more game/word attempt
     */
    public function heal(int $value = 1): self
    {
        $this->lives + $value < $this->max_lives ? $this->lives += $value : $this->lives = $this->max_lives;
        return $this;
    }

    /**
     * Damage the player with one or more game/word attempt
     */
    public function damage(int $value = 1): self
    {
        $this->lives - $value > 0 ? $this->lives -= $value : $this->gameOver();
        return $this;
    }

    /**
     * Give one or more attempt to guess the word
     */
    public function recharge(int $value = 1): self
    {
        $this->attempts_left + $value < $this->max_attempts ? $this->attempts_left += $value : $this->attempts_left = $this->max_attempts;
        return $this;
    }

    /**
     * Discharge one or more attempt to guess the word
     */
    public function discharge(int $value = 1): self
    {
        $this->attempts_left - $value > 0 ? $this->attempts_left -= $value : $this->attempts_left = 0;

        if ($this->attempts_left === 0) $this->damage();

        return $this;
    }

    /**
     * Ends a game
     */
    public function gameOver(): self
    {
        $this->attempts_left = 0;
        $this->lives = 0;
        $this->status = 'finished';
        return $this;
    }

    public function allStatusCorrect($collection): bool
    {
        return $collection->every(function ($item) {
            return isset($item['status']) && $item['status'] === 'correct';
        });
    }
}

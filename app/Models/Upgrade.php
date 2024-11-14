<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Upgrade extends Model
{
    /** @use HasFactory<\Database\Factories\UpgradeFactory> */
    use HasFactory;

    protected $fillable = [
        'game_session_id',
        'name',
        'description',
        'effect',
        'isActive'
    ];

    public function gameSession(): BelongsTo
    {
        return $this->belongsTo(GameSession::class);
    }

    public function activate(): self
    {
        $decoded = json_decode($this->effect);
        $effect = $decoded->effect;
        $this->$effect($decoded->value);
        return $this;
    }

    public function heal($value): void
    {
        $this->gameSession->heal($value);
    }
}

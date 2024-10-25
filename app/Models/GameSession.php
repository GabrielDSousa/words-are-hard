<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    /** @use HasFactory<\Database\Factories\GameSession> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score',
        'attempts_left',
        'lives',
        'status',
    ];

    /**
     * Define User relation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

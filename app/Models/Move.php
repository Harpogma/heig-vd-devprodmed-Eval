<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Move extends Model
{
    protected $table = 'moves';

    protected $fillable = ['title', 'strike_id', 'character_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function strike(): BelongsTo
    {
        return $this->belongsTo(Strike::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function score(): int
    {
        return (int) $this->votes()->sum('weight');
    }
}

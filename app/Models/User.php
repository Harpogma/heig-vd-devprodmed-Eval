<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['character_slug'];

    public function character(): ?object
    {
        return Character::findBySlug($this->character_slug);
    }

    /**
     * Get the moves for the user.
     */
    public function moves(): HasMany
    {
        return $this->hasMany(Move::class);
    }

    /**
     * Get the moves liked by the user.
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Move::class, 'likes')->using(Like::class)->withTimestamps()->withPivot('reaction');
    }
}

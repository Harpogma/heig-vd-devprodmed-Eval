<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['character_slug'];

    public function character(): ?Character
    {
        return Character::findBySlug($this->character_slug);
    }

    public function moves(): HasMany
    {
        return $this->hasMany(Move::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}

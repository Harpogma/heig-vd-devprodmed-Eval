<?php

namespace App\Models;

use App\Enums\Archetype;
use App\Enums\AntiArchetype;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Character extends Model
{
    protected $table = 'characters';

    protected $casts = [
        'archetype'      => Archetype::class,
        'anti_archetype' => AntiArchetype::class,
    ];

    public function moves(): HasMany
    {
        return $this->hasMany(Move::class);
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }
}

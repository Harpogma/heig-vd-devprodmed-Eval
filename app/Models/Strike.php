<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Strike extends Model
{
    protected $table = 'strikes';

    public function moves(): HasMany
    {
        return $this->hasMany(Move::class);
    }
}

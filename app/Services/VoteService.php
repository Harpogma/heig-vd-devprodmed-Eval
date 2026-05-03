<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Move;
use App\Models\User;
use App\Models\Vote;
use DomainException;

class VoteService
{
    public function cast(User $user, Move $move, string $type): Vote
    {
        if ($move->user_id === $user->id) {
            throw new DomainException('own_move');
        }

        if ($move->votes()->where('user_id', $user->id)->exists()) {
            throw new DomainException('already_voted');
        }

        if (!$user->character_slug) {
            throw new DomainException('no_character');
        }

        $moveCharacter  = $move->character;
        $voterCharacter = Character::findBySlug($user->character_slug);

        $baseWeight = ($voterCharacter && $moveCharacter
            && $voterCharacter->archetype->value === $moveCharacter->anti_archetype->value)
            ? 2
            : 1;

        $weight = $type === 'buff' ? +$baseWeight : -$baseWeight;

        return Vote::create([
            'user_id' => $user->id,
            'move_id' => $move->id,
            'type'    => $type,
            'weight'  => $weight,
        ]);
    }
}

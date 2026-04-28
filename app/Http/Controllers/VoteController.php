<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Move;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(Request $request, Move $move)
    {
        $user = Auth::user();

        if ($move->user_id === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas voter pour votre propre Move.');
        }

        if ($move->votes()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Vous avez déjà voté pour ce Move.');
        }

        if (!$user->character_slug) {
            return redirect()->route('character.select');
        }

        $validated = $request->validate([
            'type' => ['required', 'in:buff,nerf'],
        ]);

        $moveCharacter  = $move->character;
        $voterCharacter = Character::findBySlug($user->character_slug);

        $weight = ($voterCharacter && $moveCharacter
            && $voterCharacter->archetype->value === $moveCharacter->anti_archetype->value)
            ? 2
            : 1;

        Vote::create([
            'user_id' => $user->id,
            'move_id' => $move->id,
            'type'    => $validated['type'],
            'weight'  => $weight,
        ]);

        return back();
    }
}

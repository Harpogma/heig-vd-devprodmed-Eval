<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterSelectionController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->character_slug) {
            return redirect()->route('my-profile.show');
        }

        return view('character.select', ['characters' => Character::all()]);
    }

    public function store(Request $request)
    {
        $validSlugs = array_map(fn($c) => $c->slug, Character::all());

        $validated = $request->validate([
            'character_slug' => ['required', 'string', 'in:' . implode(',', $validSlugs)],
        ]);

        $user = Auth::user();
        $user->character_slug = $validated['character_slug'];
        $user->save();

        return redirect()->route('my-profile.show')->with('success', 'Personnage sélectionné avec succès !');
    }
}

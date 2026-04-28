<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Move;
use App\Models\Strike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MoveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $moves = Move::orderBy('created_at', 'desc')->with('user')->with('votes')->get();

        return view('moves.index', ['moves' => $moves]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $strikes    = Strike::all();
        $characters = Character::all();

        return view('moves.create', compact('strikes', 'characters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'nullable|string|max:255',
            'strike_id'    => 'nullable|exists:strikes,id',
            'character_id' => 'nullable|exists:characters,id',
        ]);

        $move = new Move($validated);
        $move->user_id = Auth::id();

        $move->save();

        return redirect("/moves/$move->id");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $move = Move::with(['user', 'strike', 'character', 'votes'])->findOrFail($id);

        $userVote = Auth::check()
            ? $move->votes()->where('user_id', Auth::id())->first()
            : null;

        return view('moves.show', ['move' => $move, 'userVote' => $userVote]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $move = Move::findOrFail($id);

        Gate::authorize('update', $move);

        return view('moves.edit', ['move' => $move]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
        ]);

        $move = Move::findOrFail($id);

        Gate::authorize('update', $move);

        $move->title = $validated['title'];

        $move->save();

        return redirect("/moves/$move->id");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $move = Move::findOrFail($id);

        Gate::authorize('delete', $move);

        $move->delete();

        return redirect("/moves");
    }
}

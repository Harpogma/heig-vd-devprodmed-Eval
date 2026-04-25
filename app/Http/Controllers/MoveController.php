<?php

namespace App\Http\Controllers;

use App\Models\Move;
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
        $moves = Move::orderBy('created_at', 'desc')->with('user')->with('likes')->get();

        return view('moves.index', ['moves' => $moves]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('moves.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $user = $request->user();
        $move = new Move();

        $move->title = $validated['title'];
        $move->content = $validated['content'];
        $move->user()->associate($user);

        $move->save();

        return redirect("/moves/$move->id");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $move = Move::with('user')->with('likes')->findOrFail($id);

        $user = Auth::user();
        $reaction = null;

        if ($user) {
            $reaction = $move->likes()->where('user_id', $user->id)->first();

            if ($reaction) {
                $reaction = $reaction->pivot->reaction;
            }
        }

        return view('moves.show', ['move' => $move, 'reaction' => $reaction]);
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
            'content' => 'required|string|max:5000',
        ]);

        $move = Move::findOrFail($id);

        Gate::authorize('update', $move);

        $move->title = $validated['title'];
        $move->content = $validated['content'];

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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Move;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoveController extends Controller
{
    public function index()
    {
        $moves = Move::with(['user', 'strike', 'character'])->get();

        return response()->json($moves);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'strike_id'    => ['required', 'exists:strikes,id'],
            'character_id' => ['required', 'exists:characters,id'],
        ]);

        $move = new Move($validated);
        $move->user_id = Auth::id();
        $move->save();

        return response()->json($move->load(['strike', 'character']), 201);
    }
}

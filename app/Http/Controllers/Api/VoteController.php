<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Move;
use App\Services\VoteService;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function __construct(private VoteService $voteService) {}

    public function store(Request $request, Move $move)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:buff,nerf'],
        ]);

        try {
            $this->voteService->cast(Auth::user(), $move, $validated['type']);
        } catch (DomainException $e) {
            $status = match ($e->getMessage()) {
                'own_move'     => 403,
                'already_voted' => 409,
                'no_character' => 422,
                default        => 400,
            };

            return response()->json(['message' => $e->getMessage()], $status);
        }

        return response()->json([
            'message' => 'Vote enregistré',
            'score'   => $move->score(),
        ]);
    }
}

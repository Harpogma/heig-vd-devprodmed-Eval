<?php

namespace App\Http\Controllers;

use App\Models\Move;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'reaction' => ['required', 'in:like,love,haha,wow,sad,angry'],
        ]);

        $move = Move::findOrFail($id);
        $user = $request->user();
        $reaction = $validated['reaction'];

        $existingLike = $move->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            if ($existingLike->pivot->reaction === $reaction) {
                $move->likes()->detach($user->id);
            } else {
                $move->likes()->updateExistingPivot($user->id, ['reaction' => $reaction]);
            }
        } else {
            $move->likes()->attach($user->id, ['reaction' => $reaction]);
        }

        return redirect("/moves/$id");
    }
}

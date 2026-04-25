<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCharacterSelected
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->character_slug && !$request->routeIs('character.select', 'character.store')) {
            return redirect()->route('character.select');
        }

        return $next($request);
    }
}

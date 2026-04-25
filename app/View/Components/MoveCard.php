<?php

namespace App\View\Components;

use App\Models\Move;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MoveCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Move $move,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.move-card');
    }
}

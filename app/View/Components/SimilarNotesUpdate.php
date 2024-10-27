<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SimilarNotesUpdate extends Component
{
    public $notes;

    public function __construct($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.similar-notes-update');
    }
}

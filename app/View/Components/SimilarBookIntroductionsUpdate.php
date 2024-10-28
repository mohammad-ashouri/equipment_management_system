<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SimilarBookIntroductionsUpdate extends Component
{
    public $bookIntroductions;

    public function __construct($bookIntroductions)
    {
        $this->bookIntroductions = $bookIntroductions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.similar-book-introductions-update');
    }
}

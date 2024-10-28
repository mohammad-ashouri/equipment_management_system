<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SpecialCaseMultimediaUpdate extends Component
{
    public  $multimedia;

    public function __construct($multimedia)
    {
        $this->multimedia = $multimedia;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.special-case-multimedia-update');
    }
}

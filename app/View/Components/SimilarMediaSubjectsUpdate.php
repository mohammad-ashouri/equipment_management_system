<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SimilarMediaSubjectsUpdate extends Component
{
    public  $mediaSubjects;

    public function __construct($mediaSubjects)
    {
        $this->mediaSubjects = $mediaSubjects;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.similar-media-subjects-update');
    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SimilarResearchSubjectsUpdate extends Component
{
    public  $researchSubjects;

    public function __construct($researchSubjects)
    {
        $this->researchSubjects = $researchSubjects;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.similar-research-subjects-update');
    }
}

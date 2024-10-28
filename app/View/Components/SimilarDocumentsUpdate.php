<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SimilarDocumentsUpdate extends Component
{
    public $documents;

    public function __construct($documents)
    {
        $this->documents = $documents;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.similar-documents-update');
    }
}

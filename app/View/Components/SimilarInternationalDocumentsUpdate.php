<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SimilarInternationalDocumentsUpdate extends Component
{
    public $internationalDocuments;

    public function __construct($internationalDocuments)
    {
        $this->internationalDocuments = $internationalDocuments;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.similar-international-documents-update');
    }
}

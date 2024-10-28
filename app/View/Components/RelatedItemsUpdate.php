<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RelatedItemsUpdate extends Component
{
    public $postTypes;
    public $relatedItems;

    public function __construct($postTypes, $relatedItems)
    {
        $this->postTypes = $postTypes;
        $this->relatedItems = $relatedItems;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.related-items-update');
    }
}

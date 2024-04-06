<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DashLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $term_name;
    public $term_academic_year;

    public function __construct($term_name, $term_academic_year){
        $this->term_name = $term_name;
        $this->term_academic_year = $term_academic_year;
    }

    public function render(): View
    {
        return view('components.dash-term');
    }
}

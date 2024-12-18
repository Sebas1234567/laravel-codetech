<?php

namespace Code\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public $sections;
    public $secondNav;

    public function __construct($sections,$secondNav)
    {
        $this->sections = $sections;
        $this->secondNav = $secondNav;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}

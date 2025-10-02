<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Form extends Component
{
    public $method;
    public $action;
    public $enctype;
    public $class;
    public $novalidate;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $method = 'POST',
        $action = '',
        $enctype = 'application/x-www-form-urlencoded',
        $class = '',
        $novalidate = false
    ) {
        $this->method = strtoupper($method);
        $this->action = $action;
        $this->enctype = $enctype;
        $this->class = $class;
        $this->novalidate = $novalidate;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.form');
    }
}


<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Alert extends Component
{
    public $type;
    public $title;
    public $dismissible;
    public $class;
    public $icon;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $type = 'info',
        $title = null,
        $dismissible = true,
        $class = '',
        $icon = null
    ) {
        $this->type = $type;
        $this->title = $title;
        $this->dismissible = $dismissible;
        $this->class = $class;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.alert');
    }
}


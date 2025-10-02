<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Button extends Component
{
    public $type;
    public $variant;
    public $size;
    public $class;
    public $disabled;
    public $loading;
    public $icon;
    public $iconPosition;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $type = 'button',
        $variant = 'primary',
        $size = 'md',
        $class = '',
        $disabled = false,
        $loading = false,
        $icon = null,
        $iconPosition = 'left'
    ) {
        $this->type = $type;
        $this->variant = $variant;
        $this->size = $size;
        $this->class = $class;
        $this->disabled = $disabled;
        $this->loading = $loading;
        $this->icon = $icon;
        $this->iconPosition = $iconPosition;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.button');
    }
}


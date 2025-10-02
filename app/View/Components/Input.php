<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    public $type;
    public $name;
    public $label;
    public $placeholder;
    public $value;
    public $required;
    public $disabled;
    public $readonly;
    public $class;
    public $labelClass;
    public $helpText;
    public $error;
    public $icon;
    public $iconPosition;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $type = 'text',
        $name = '',
        $label = null,
        $placeholder = '',
        $value = '',
        $required = false,
        $disabled = false,
        $readonly = false,
        $class = '',
        $labelClass = '',
        $helpText = null,
        $error = null,
        $icon = null,
        $iconPosition = 'left'
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
        $this->class = $class;
        $this->labelClass = $labelClass;
        $this->helpText = $helpText;
        $this->error = $error;
        $this->icon = $icon;
        $this->iconPosition = $iconPosition;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.input');
    }
}


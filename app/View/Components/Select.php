<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Select extends Component
{
    public $name;
    public $label;
    public $options;
    public $value;
    public $required;
    public $disabled;
    public $class;
    public $labelClass;
    public $helpText;
    public $error;
    public $icon;
    public $placeholder;
    public $multiple;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $name = '',
        $label = null,
        $options = [],
        $value = '',
        $required = false,
        $disabled = false,
        $class = '',
        $labelClass = '',
        $helpText = null,
        $error = null,
        $icon = null,
        $placeholder = null,
        $multiple = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->class = $class;
        $this->labelClass = $labelClass;
        $this->helpText = $helpText;
        $this->error = $error;
        $this->icon = $icon;
        $this->placeholder = $placeholder;
        $this->multiple = $multiple;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.select');
    }
}


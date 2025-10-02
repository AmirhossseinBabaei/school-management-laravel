<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Modal extends Component
{
    public $id;
    public $title;
    public $size;
    public $centered;
    public $scrollable;
    public $backdrop;
    public $keyboard;
    public $class;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $id = '',
        $title = '',
        $size = 'md',
        $centered = true,
        $scrollable = false,
        $backdrop = true,
        $keyboard = true,
        $class = ''
    ) {
        $this->id = $id ?: 'modal_' . uniqid();
        $this->title = $title;
        $this->size = $size;
        $this->centered = $centered;
        $this->scrollable = $scrollable;
        $this->backdrop = $backdrop;
        $this->keyboard = $keyboard;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.modal');
    }
}


<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PageHeader extends Component
{
    public $title;
    public $subtitle;
    public $icon;
    public $class;
    public $actions;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $title = '',
        $subtitle = null,
        $icon = null,
        $class = '',
        $actions = null
    ) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->icon = $icon;
        $this->class = $class;
        $this->actions = $actions;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.page-header');
    }
}


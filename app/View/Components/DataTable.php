<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DataTable extends Component
{
    public $headers;
    public $data;
    public $class;
    public $striped;
    public $hover;
    public $bordered;
    public $responsive;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $headers = [],
        $data = [],
        $class = '',
        $striped = true,
        $hover = true,
        $bordered = false,
        $responsive = true
    ) {
        $this->headers = $headers;
        $this->data = $data;
        $this->class = $class;
        $this->striped = $striped;
        $this->hover = $hover;
        $this->bordered = $bordered;
        $this->responsive = $responsive;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.data-table');
    }
}


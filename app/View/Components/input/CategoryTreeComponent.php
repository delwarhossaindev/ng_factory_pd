<?php

namespace App\View\Components\input;

use Illuminate\View\Component;

class CategoryTreeComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.category-tree-component',[
            'data' => $this->data
        ]);
    }
}

<?php

namespace App\View\Components\input;

use Illuminate\View\Component;

class TagComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $label, $data;
    public function __construct($label, $data)
    {
        $this->label = $label;
        $this->data  = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.tag-component',[
            'data'  => $this->data,
            'label' => $this->label
        ]);
    }
}

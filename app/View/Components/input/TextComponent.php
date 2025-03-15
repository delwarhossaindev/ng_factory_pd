<?php

namespace App\View\Components\input;

use Illuminate\View\Component;

class TextComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $label, $name, $data;

    public function __construct($label, $name, $data)
    {   
        $this->label = $label;
        $this->data  = $data;
        $this->name  = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.text-component',[
            'data'  => $this->data,
            'label' => $this->label,
            'name'  => $this->name
        ]);
    }
}

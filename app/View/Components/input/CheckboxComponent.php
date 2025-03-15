<?php

namespace App\View\Components\input;

use Illuminate\View\Component;

class CheckboxComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $label, $name, $data, $class;

    public function __construct($label, $name, $data, $class)
    {   
        $this->label = $label;
        $this->data  = $data;
        $this->name  = $name;
        $this->class = $class;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.checkbox-component',[
            'data'  => $this->data,
            'label' => $this->label,
            'name'  => $this->name,
            'class' => $this->class
        ]);
    }
}

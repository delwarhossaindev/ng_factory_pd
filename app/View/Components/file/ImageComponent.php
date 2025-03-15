<?php

namespace App\View\Components\file;

use Illuminate\View\Component;

class ImageComponent extends Component
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
        return view('components.file.image-component',['data' => $this->data]);
    }
}

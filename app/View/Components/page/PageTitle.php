<?php

namespace App\View\Components\page;

use Illuminate\View\Component;

class PageTitle extends Component
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
        return view('components.page.page-title',['data' => $this->data]);
    }
}

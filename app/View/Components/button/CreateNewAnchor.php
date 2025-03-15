<?php

namespace App\View\Components\button;

use Illuminate\View\Component;

class CreateNewAnchor extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $title, $buttonText, $permalink, $permission;

     public function __construct($title, $buttonText, $permalink, $permission)
     {
         $this->title      = $title;
         $this->buttonText = $buttonText;
         $this->permalink  = $permalink;
         $this->permission = $permission;
     }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button.create-new-anchor',[
            'title' => $this->title,
            'buttonText' => $this->buttonText,
            'permalink' => $this->permalink,
            'permission' => $this->permission
        ]);
    }
}
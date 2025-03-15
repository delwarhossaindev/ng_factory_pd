<?php

namespace App\View\Components\button;

use Illuminate\View\Component;

class CreateNewModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title, $buttonText, $permission;

    public function __construct($title, $buttonText, $permission)
    {
        $this->title      = $title;
        $this->buttonText = $buttonText;
        $this->permission = $permission;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button.create-new-modal', [
            'title' => $this->title,
            'buttonText' => $this->buttonText,
            'permission' => $this->permission
        ]);
    }
}

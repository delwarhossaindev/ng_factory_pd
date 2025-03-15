<?php

namespace App\View\Components\breadcrumb;

use Illuminate\View\Component;

class BreadcrumbComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $firstLabel, $firstLabelRoute, $secondLable, $secondLabelRoute, $currentPageText;

    public function __construct(
        $firstLabel, 
        $firstLabelRoute, 
        $secondLable, 
        $secondLabelRoute, 
        $currentPageText
    ){
        $this->firstLabel       = $firstLabel;
        $this->firstLabelRoute  = $firstLabelRoute;
        $this->secondLable      = $secondLable;
        $this->secondLabelRoute = $secondLabelRoute;
        $this->currentPageText  = $currentPageText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.breadcrumb.breadcrumb-component',[
            'firstLabel'       => $this->firstLabel,
            'firstLabelRoute'  => $this->firstLabelRoute,
            'secondLable'      => $this->secondLable,
            'secondLabelRoute' => $this->secondLabelRoute,
            'currentPageText'  => $this->currentPageText,
        ]);
    }
}

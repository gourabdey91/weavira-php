<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ButtonComponent extends Component
{
    public $buttonlabel;
    public $buttonlink;
    public $buttonclass;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($buttonlabel, $buttonlink = null, $buttonclass = null)
    {
        $this->buttonlabel = $buttonlabel;
        $this->buttonlink = $buttonlink;
        $this->buttonclass = $buttonclass;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button-component');
    }
}
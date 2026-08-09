<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImageComponent extends Component
{

    public $title;
    public $imageElement;
 

    public function __construct($title, $imageElement = null)
    {
        $this->title = $title; 
        $this->imageElement = $imageElement;
    }
 

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.image-component');
    }
}
<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BrandlogoComponent extends Component
{
    public $enableSection;
    public $title;
    public $brandsLogos;

    public function __construct()
    {
        // Fetch ACF fields
        $this->enableSection = get_field('bwww_enable_section','options');
        $this->title = get_field('bwww_title','options');
        $this->brandsLogos = get_field('bwww_brands_logos','options');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.brandlogo-component');
    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $name;
    public string $label;
    public string $type;
    public string $placeholder;
    public $value;
    public int $col;
    public string $cssClass;
    public bool $showLabel;

    /**
     * Create a new component instance.
     * @param $name
     * @param string $label
     * @param string $type
     * @param string $placeholder
     * @param null $value
     * @param int $col
     * @param string $cssClass
     * @param bool $noLabel
     */
    public function __construct($name, $label = '', $type = 'text', $placeholder = '', $value = null, $col = 0, $cssClass = '', bool $showLabel = true)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->col = $col;
        $this->cssClass = $cssClass;
        $this->showLabel = $showLabel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.input');
    }
}

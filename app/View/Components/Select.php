<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public array $options;
    public string $selected;
    public string $placeholder;
    public string $optionAll;
    public string $icon;
    public bool $sameKeyValue;
    public bool $isFilter;
    public bool $disabled;
    public string $label;
    public int $col;
    public string $cssClass;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param array $options
     * @param string $selected
     * @param string $placeholder
     * @param string $optionAll
     * @param string $icon
     * @param bool $sameKeyValue
     * @param bool $isFilter
     * @param bool $disabled
     * @param string $label
     * @param int $col
     * @param string $cssClass
     */
    public function __construct($name, array $options, $selected = '', $placeholder = '', $optionAll = '', $icon = '',
                                $sameKeyValue = false, $isFilter = false, $disabled = false, $label = '', $col = 0, $cssClass = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->col = $col;
        $this->placeholder = $placeholder;
        $this->options = $options;
        $this->selected = $selected;
        $this->optionAll = $optionAll;
        $this->icon = $icon;
        $this->sameKeyValue = $sameKeyValue;
        $this->isFilter = $isFilter;
        $this->disabled = $disabled;
        $this->cssClass = $cssClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.select');
    }
}

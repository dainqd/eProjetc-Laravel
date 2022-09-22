<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ButtonDelete extends Component
{
    public string $href;
    public int $id;
    public string $content;

    /**
     * Create a new component instance.
     *
     * @param string $href
     * @param string|int $id
     * @param string $content
     */
    public function __construct(string $href, string|int $id, string $content = '')
    {
        $this->href = $href;
        $this->id = $id;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.button-delete');
    }
}

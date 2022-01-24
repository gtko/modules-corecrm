<?php

namespace Modules\CoreCRM\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use Modules\CoreCRM\Models\Flow;

class TimelineResolve extends Component
{

    public function __construct(
      public Flow $flow
    ){}

    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $nameComponent = Str::replace('Flow\Attributes', "View\Components\Timeline", $this->flow->event->key);

        if(class_exists($nameComponent)) {
            $component = (new $nameComponent($this->flow));
            return $component->render();
        }

        return '';
    }
}

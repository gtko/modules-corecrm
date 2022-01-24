<?php


namespace Modules\CoreCRM\View\Components\Timeline;


use Illuminate\View\View;
use Modules\CoreCRM\Models\Flow;

abstract class TimelineComponent
{

    public function __construct(
        public Flow $flow
    ){}


    abstract function render(): ?View;
}

<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;

abstract class WorkFlowVariable
{

    public WorkFlowEvent $event;

    public function __construct(WorkFlowEvent $event){
        $this->event = $event;
    }

    abstract public function namespace():string;
    abstract public function data():array;
    abstract public function labels():array;


}

<?php

namespace Modules\CoreCRM\Flow\Works\Files;

use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;

abstract class WorkFlowFiles
{

    public WorkFlowEvent $event;

    public function __construct(WorkFlowEvent $event){
        $this->event = $event;
    }

    abstract public function name():string;
    abstract public function description():string;
    abstract public function content():string;
    abstract public function filename():string;
    abstract public function mimetype():string;

}

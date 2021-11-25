<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Flow\Works\Interfaces\WorkFlowDescribe;

abstract class WorkFlowAction implements WorkFlowDescribe
{
    public WorkFlowEvent $event;
    public array $params;

    public function __construct(WorkFlowEvent $event){
        $this->event = $event;
    }

    /**
     * Instancie les paramètre stocker en bdd et retourne l'instance du params
     */
    public function initParams($params){
        $paramsRequire = $this->params();
        foreach($params as $index => $value){
            $instance = (new $paramsRequire[$index]);
            $instance->setValue($value);
            $this->params[] = $instance;
        }
    }

    abstract public function handle();
    abstract public function params():array;
}

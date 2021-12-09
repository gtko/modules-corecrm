<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Flow\Works\Interfaces\WorkFlowDescribe;
use Modules\CoreCRM\Flow\Works\Params\ParamsTag;

abstract class WorkFlowAction implements WorkFlowDescribe
{
    public WorkFlowEvent $event;
    public array $params;

    public function __construct(WorkFlowEvent $event){
        $this->event = $event;
    }


    public function isVariabled():bool
    {
        return false;
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

    public function params(): array
    {
        $params = [];
        foreach ($this->prepareParams() as $param){
            $params[] = (new $param);
        }

        return $params;
    }

    abstract public function handle();
    abstract protected function prepareParams():array;
}

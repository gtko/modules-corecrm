<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\WorkFlowAction;
use Modules\CoreCRM\Flow\Works\CategoriesEventEnum;
use Modules\CoreCRM\Flow\Works\Conditions\WorkFlowCondition;
use Modules\CoreCRM\Flow\Works\Interfaces\WorkFlowDescribe;
use Modules\CoreCRM\Models\Flow;

abstract class WorkFlowEvent implements WorkFlowDescribe
{

    protected array $data = [];


    abstract protected function prepareData(Attributes $flowAttribute):array;
    abstract public function listen():array;
    abstract public function actions():array;

    public function category():string
    {
        return CategoriesEventEnum::OTHER;
    }

    public function conditions():array
    {
        return [];
    }

    public function variables():array
    {
        return [];
    }

    public function files():array
    {
        return [];
    }

    public function init(Flow $flow){
        $this->data = $this->prepareData($flow->datas);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function makeAction($class):?WorkFlowAction
    {
        try {
            $actions = $this->actions();
            return new ($actions[array_search($class, $actions, true)])($this);
        }catch(\Exception $e){

        }

        return null;
    }

    public function makeCondition($class):?WorkFlowCondition
    {
        try {
            $actions = $this->conditions();
            return new ($actions[array_search($class, $actions, true)])($this);
        }catch(\Exception $e){

        }

        return null;
    }

}

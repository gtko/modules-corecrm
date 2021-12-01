<?php

namespace Modules\CoreCRM\Flow\Works\Conditions;

use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Flow\Works\Interfaces\WorkFlowDescribe;
use Modules\CoreCRM\Flow\Works\Params\ParamsString;

abstract class WorkFlowConditionArray extends WorkFlowCondition
{

    abstract public function getValueItem($item);

    public function conditions():array
    {
        return [
            'in' => 'Contiens',
            'notin' => 'Ne contiens pas'
        ];
    }

    public function resolve($comparateur){
        $valid = false;
        switch($comparateur){
            case 'in' :
                $valid = in_array($this->getValue(), $this->getValueTarget());
                break;
            case 'notin' :
                $valid = !in_array($this->getValue(), $this->getValueTarget());
                break;
        }

        return $valid;
    }
}

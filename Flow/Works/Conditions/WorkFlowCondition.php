<?php

namespace Modules\CoreCRM\Flow\Works\Conditions;

use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Flow\Works\Interfaces\WorkFlowDescribe;
use Modules\CoreCRM\Flow\Works\Params\ParamsString;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;

abstract class WorkFlowCondition implements WorkFlowDescribe
{

    public $valueTarget;

    public function __construct(protected WorkFlowEvent $event){}

    abstract public function param():?WorkFlowParams;
    abstract public function getValue();


    public function initTarget($valueTarget){
        $this->valueTarget = $valueTarget;
    }
    public function getValueTarget(){
        return $this->valueTarget;
    }

    public function resolve($comparateur){
        $valid = false;
        switch($comparateur){
            case '==' :
                $valid = $this->getValueTarget() == $this->getValue();
                break;
            case '!=' :
                $valid = $this->getValueTarget() != $this->getValue();
                break;
            case '<' :
                $valid = $this->getValue() < $this->getValueTarget();
                break;
            case '>' :
                $valid = $this->getValue() > $this->getValueTarget();
                break;
            case '<=' :
                $valid = $this->getValue() <= $this->getValueTarget();
                break;
            case '>=' :
                $valid = $this->getValue() >= $this->getValueTarget();
                break;
        }

        return $valid;
    }

    public function conditions():array
    {
        return [
            '==' => 'Egal à',
            '!=' => 'Différent de',
            '<' => 'Plus petit que',
            '>' => 'Plus grand que',
            '<=' => 'Plus petit ou égal à',
            '>=' => 'Plus ou égal à'
        ];
    }
}

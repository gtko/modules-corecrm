<?php

namespace Modules\CoreCRM\Flow\Works\Params;


use Modules\CoreCRM\Flow\Works\Interfaces\WorkFlowDescribe;

abstract class WorkFlowParams implements WorkFlowDescribe
{

    public $value;

    public function setValue($value){
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }


}

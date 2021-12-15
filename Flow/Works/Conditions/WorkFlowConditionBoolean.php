<?php

namespace Modules\CoreCRM\Flow\Works\Conditions;

use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Flow\Works\Interfaces\WorkFlowDescribe;
use Modules\CoreCRM\Flow\Works\Params\ParamsString;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;

abstract class WorkFlowConditionBoolean extends WorkFlowCondition
{
    public function conditions():array
    {
        return [
            '==' => 'Egal à',
            '!=' => 'Différent de',
        ];
    }
}

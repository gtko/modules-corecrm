<?php

namespace Modules\CoreCRM\Flow\Works\Conditions;

use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Flow\Works\Params\ParamsStatus;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;

class ConditionStatus extends WorkFlowCondition
{
    public function name():string
    {
        return 'Comparer status';
    }
    public function describe(): string
    {
        return 'Comparer avec le status en court dans le dossier';
    }

    public function param():WorkFlowParams
    {
        return new (ParamsStatus::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();
        return $data['dossier']->status->order;
    }

    public function getValueTarget(){
        $param = $this->param();
        $param->setValue($this->valueTarget);
        return $param->getValue()->order ?? null;
    }

}

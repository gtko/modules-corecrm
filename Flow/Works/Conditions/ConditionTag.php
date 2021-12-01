<?php

namespace Modules\CoreCRM\Flow\Works\Conditions;

use Modules\CoreCRM\Flow\Works\Params\ParamsStatus;
use Modules\CoreCRM\Flow\Works\Params\ParamsTag;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;

class ConditionTag extends WorkFlowConditionArray
{
    public function name():string
    {
        return 'Comparer les tags';
    }
    public function describe(): string
    {
        return 'Comparer avec un tag accroche ou non sur le dossier';
    }

    public function param():WorkFlowParams
    {
       return new (ParamsTag::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();
        return $data['dossier']->tags;
    }

    public function getValueItem($item)
    {
        return $item->id;
    }
}

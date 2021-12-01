<?php

namespace Modules\CoreCRM\Flow\Works\Conditions;

use Modules\CoreCRM\Flow\Works\Params\ParamsString;
use Modules\CoreCRM\Flow\Works\Params\ParamsTag;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;

class ConditionCountDossier extends WorkFlowCondition
{
    public function name():string
    {
        return 'Combien de dossier';
    }
    public function describe(): string
    {
        return 'Comparer le nombre de dossier que le client possède';
    }

    public function param():WorkFlowParams
    {
        return new (ParamsString::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();
        return $data['dossier']->client->dossiers()->count();
    }

}

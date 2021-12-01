<?php

namespace Modules\CoreCRM\Flow\Works\Conditions;

use Modules\CoreCRM\Flow\Works\Params\ParamsNumber;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;

class ConditionCountDevis extends WorkFlowCondition
{


    public function param():WorkFlowParams
    {
        return new (ParamsNumber::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();
        return $data['dossier']->devis()->count();
    }

    public function name(): string
    {
        return 'Nombre de devis créé';
    }

    public function describe(): string
    {
        return 'Compare le nombre devis actuellement créer sur le dossier';
    }
}

<?php

namespace Modules\CoreCRM\Flow\Works\Params;

class ParamsBoolean extends WorkFlowParams
{

    public function name(): string
    {
        return 'Valeur';
    }

    public function describe(): string
    {
        return '';
    }


    function nameView(): string
    {
        return "corecrm::workflows.boolean";
    }

}

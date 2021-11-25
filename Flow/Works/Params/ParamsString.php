<?php

namespace Modules\CoreCRM\Flow\Works\Params;

class ParamsString extends WorkFlowParams
{


    public function name(): string
    {
        return 'Valeur';
    }

    public function describe(): string
    {
        return "Entrez une valeur sous forme de texte";
    }

    public function getValue()
    {
        // TODO: Implement getValue() method.
    }
}

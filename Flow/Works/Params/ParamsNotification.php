<?php

namespace Modules\CoreCRM\Flow\Works\Params;

class ParamsNotification extends WorkFlowParams
{

    public function name(): string
    {
        return 'Notification';
    }

    public function describe(): string
    {
        return '';
    }

    public function getValue()
    {
        return $this->value;
    }


}

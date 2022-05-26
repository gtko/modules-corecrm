<?php

namespace Modules\CoreCRM\Flow\Works\Params;

class ParamsTimeline extends WorkFlowParams
{

    public function name(): string
    {
        return 'Timeline';
    }

    public function describe(): string
    {
        return '';
    }

    public function getValue()
    {
        return $this->value;
    }


    function nameView(): string
    {
        return "corecrm::workflows.timeline";
    }
}

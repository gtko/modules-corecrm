<?php

namespace Modules\CoreCRM\Flow\Works\Params;

class ParamsNotificationPush extends WorkFlowParams
{

    public function name(): string
    {
        return 'NotificationPush';
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
        return "corecrm::workflows.notification-push";
    }
}

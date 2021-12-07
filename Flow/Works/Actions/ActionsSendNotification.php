<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Modules\CoreCRM\Flow\Works\Params\ParamsNotification;

class ActionsSendNotification extends WorkFlowAction
{


    public function handle()
    {
        // TODO: Implement handle() method.
    }

    public function isVariabled():bool
    {
        return true;
    }

    protected function prepareParams(): array
    {
        return [
            ParamsNotification::class
        ];
    }

    public function name(): string
    {
        return 'Envoyer une notification (CRM,EMAIL)';
    }

    public function describe(): string
    {
        return 'Permet de notifier un utilisateur du CRM par tous les canaux disponible, crm, email';
    }
}

<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierCreate;

class EventClientDossierCreate extends WorkFlowEvent
{

    public function listen():array
    {
        return [
            ClientDossierCreate::class
        ];
    }

    public function category():string
    {
        return 'Dossier';
    }

    public function name():string
    {
        return "Création d'un dossier";
    }

    public function describe():string
    {
        return "Evenement déclencher a la création d'un dossier dans un client";
    }


    public function actions():array
    {
        return [];
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'user' => $flowAttribute->getUser()
        ];
    }
}

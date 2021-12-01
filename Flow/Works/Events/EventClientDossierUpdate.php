<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierUpdate;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;

class EventClientDossierUpdate extends WorkFlowEvent
{

    public function name(): string
    {
       return 'Dossier mis à jour';
    }

    public function category():string
    {
        return 'Dossier';
    }

    public function describe(): string
    {
        return 'Ce déclenche à la mise à jour du dossier';
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'user' => $flowAttribute->getUser()
        ];
    }

    public function listen(): array
    {
        return [
           ClientDossierUpdate::class
        ];
    }

    public function actions(): array
    {
        return [
            ActionsChangeStatus::class,
            ActionsAjouterTag::class
        ];
    }
}

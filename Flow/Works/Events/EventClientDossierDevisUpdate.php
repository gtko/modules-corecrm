<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisUpdate;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;

class EventClientDossierDevisUpdate extends WorkFlowEvent
{

    public function name(): string
    {
        return "Mise à jour d'un devis";
    }

    public function describe(): string
    {
        return "Ce déclenche à la mise à jour d'un devis.";
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        $devis = $flowAttribute->getDevis();

        return [
            'devis' => $devis,
            'dossier' => $devis->dossier,
            'user' => $flowAttribute->getUser()
        ];
    }

    public function listen(): array
    {
        return
            [
                ClientDossierDevisUpdate::class
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

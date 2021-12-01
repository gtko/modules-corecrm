<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisUpdate;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;

class EventClientDossierDevisUpdate extends WorkFlowEvent
{

    public function name(): string
    {
        return "Mise à jour d'un devis";
    }

    public function category():string
    {
        return 'Devis';
    }

    public function describe(): string
    {
        return "Ce déclenche à la mise à jour d'un devis.";
    }

    public function conditions():array
    {
        return [
            ConditionCountDevis::class,
            ConditionCountDossier::class,
            ConditionStatus::class,
            ConditionTag::class
        ];
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

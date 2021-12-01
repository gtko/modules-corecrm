<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisCreate;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;
use Modules\CoreCRM\Flow\Works\Datas\WorkDataDevis;
use Modules\CoreCRM\Models\Flow;

class EventClientDossierDevisCreate extends WorkFlowEvent
{

    public function listen(): array
    {
        return [
            ClientDossierDevisCreate::class
        ];
    }

    public function category():string
    {
        return 'Devis';
    }

    protected function prepareData(Attributes $flowAttribute):array
    {
        $devis = $flowAttribute->getDevis();

        return [
          'devis' => $devis,
          'dossier' => $devis->dossier,
          'user' => $flowAttribute->getUser()
        ];
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

    public function actions(): array
    {
        return [
            ActionsChangeStatus::class,
            ActionsAjouterTag::class
        ];
    }

    public function name(): string
    {
        return "Création d'un devis";
    }

    public function describe(): string
    {
        return "Se déclenche à la création d'un devis";
    }


}

<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisCreate;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
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

    protected function prepareData(Attributes $flowAttribute):array
    {
        $devis = $flowAttribute->getDevis();

        return [
          'devis' => $devis,
          'dossier' => $devis->dossier,
          'user' => $flowAttribute->getUser()
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

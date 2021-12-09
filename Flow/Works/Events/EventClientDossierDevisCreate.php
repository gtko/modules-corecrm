<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisCreate;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\CategoriesEventEnum;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;
use Modules\CoreCRM\Flow\Works\Datas\WorkDataDevis;
use Modules\CoreCRM\Flow\Works\Variables\ClientVariable;
use Modules\CoreCRM\Flow\Works\Variables\CommercialVariable;
use Modules\CoreCRM\Flow\Works\Variables\DeviVariable;
use Modules\CoreCRM\Flow\Works\Variables\DossierVariable;
use Modules\CoreCRM\Flow\Works\Variables\UserVariable;
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
        return CategoriesEventEnum::DEVIS;
    }

    protected function prepareData(Attributes $flowAttribute):array
    {
        $devis = $flowAttribute->getDevis();

        return [
          'devis' => $devis,
          'dossier' => $devis->dossier,
          'client' => $devis->dossier->client,
          'commercial' => $devis->dossier->commercial,
          'user' => $flowAttribute->getUser()
        ];
    }

    public function variables():array
    {
        return [
            (new DossierVariable($this)),
            (new DeviVariable($this)),
            (new UserVariable($this)),
            (new CommercialVariable($this)),
            (new ClientVariable($this)),
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

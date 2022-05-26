<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierUpdate;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNote;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNotif;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddTimeline;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Actions\ActionsDetachAllTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSupprimerTag;
use Modules\CoreCRM\Flow\Works\CategoriesEventEnum;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;
use Modules\CoreCRM\Flow\Works\Variables\ClientVariable;
use Modules\CoreCRM\Flow\Works\Variables\CommercialVariable;
use Modules\CoreCRM\Flow\Works\Variables\DeviVariable;
use Modules\CoreCRM\Flow\Works\Variables\DossierVariable;
use Modules\CoreCRM\Flow\Works\Variables\UserVariable;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionClientSolde;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionFournisseurBPA;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionFournisseurSolde;

class EventClientDossierUpdate extends WorkFlowEvent
{

    public function name(): string
    {
       return 'Dossier mis à jour';
    }

    public function category():string
    {
        return CategoriesEventEnum::DOSSIER;
    }

    public function describe(): string
    {
        return 'Ce déclenche à la mise à jour du dossier';
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'user' => $flowAttribute->getUser(),
            'dossier' => $this->flow->flowable,
        ];
    }

    public function conditions():array
    {
        return [
            ConditionCountDevis::class,
            ConditionCountDossier::class,
            ConditionStatus::class,
            ConditionTag::class,
            ConditionClientSolde::class,
            ConditionFournisseurBPA::class,
            ConditionFournisseurSolde::class
        ];
    }

    public function variables():array
    {
        return [
            (new UserVariable($this)),
        ];
    }

    public function listen(): array
    {
        return [
           ClientDossierUpdate::class
        ];
    }
}

<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierCreate;
use Modules\CoreCRM\Flow\Attributes\SheduleAttribute;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNote;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddTimeline;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
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
use Modules\CoreCRM\Flow\Works\Variables\FournisseurVariable;
use Modules\CoreCRM\Flow\Works\Variables\UserVariable;

class EventShedule extends WorkFlowEvent
{

    public function listen():array
    {
        return [
            SheduleAttribute::class
        ];
    }

    public function category():string
    {
        return "Shedule";
    }

    public function name():string
    {
        return "Lancement régulier de l'event";
    }

    public function describe():string
    {
        return "Evenement déclencher régulièrement toutes les 5 minutes";
    }


    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'dossier' => $flowAttribute->getDossier()
        ];
    }

    public function variables():array
    {
        return [
            (new UserVariable($this)),
            (new DossierVariable($this)),
        ];
    }


    public function conditions():array
    {
        return [
            ConditionCountDevis::class,
            ConditionStatus::class,
            ConditionCountDossier::class,
            ConditionTag::class,
        ];
    }
}

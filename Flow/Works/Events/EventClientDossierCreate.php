<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierCreate;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNote;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddTimeline;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSupprimerTag;
use Modules\CoreCRM\Flow\Works\CategoriesEventEnum;
use Modules\CoreCRM\Flow\Works\Variables\ClientVariable;
use Modules\CoreCRM\Flow\Works\Variables\CommercialVariable;
use Modules\CoreCRM\Flow\Works\Variables\DeviVariable;
use Modules\CoreCRM\Flow\Works\Variables\DossierVariable;
use Modules\CoreCRM\Flow\Works\Variables\FournisseurVariable;
use Modules\CoreCRM\Flow\Works\Variables\UserVariable;

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
        return CategoriesEventEnum::DOSSIER;
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
        return [
            ActionsChangeStatus::class,
            ActionsAjouterTag::class,
            ActionsAddTimeline::class,
            ActionsSupprimerTag::class,
            ActionsAddNote::class,
            ActionsSendNotification::class
        ];
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'user' => $flowAttribute->getUser(),
        ];
    }

    public function variables():array
    {
        return [
            (new UserVariable($this))
        ];
    }
}

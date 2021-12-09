<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierUpdate;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\CategoriesEventEnum;
use Modules\CoreCRM\Flow\Works\Variables\ClientVariable;
use Modules\CoreCRM\Flow\Works\Variables\CommercialVariable;
use Modules\CoreCRM\Flow\Works\Variables\DeviVariable;
use Modules\CoreCRM\Flow\Works\Variables\DossierVariable;
use Modules\CoreCRM\Flow\Works\Variables\UserVariable;

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
            'user' => $flowAttribute->getUser()
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

    public function actions(): array
    {
        return [
            ActionsChangeStatus::class,
            ActionsAjouterTag::class
        ];
    }
}

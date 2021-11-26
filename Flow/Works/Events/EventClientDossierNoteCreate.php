<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\ClientDossierNoteCreate;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;

class EventClientDossierNoteCreate extends WorkFlowEvent
{

    public function name(): string
    {
        return "Création d'une note";
    }

    public function describe(): string
    {
        return "Se déclenche à la création d'une note";
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'user' => $flowAttribute->getUser(),
            'note' => $flowAttribute->getNote()
        ];
    }

    public function listen(): array
    {
        return [
          ClientDossierNoteCreate::class
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

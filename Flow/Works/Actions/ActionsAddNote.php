<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Modules\CoreCRM\Flow\Attributes\ClientDossierNoteCreate;
use Modules\CoreCRM\Flow\Works\Params\ParamsString;
use Modules\CoreCRM\Services\FlowCRM;

class ActionsAddNote extends WorkFlowAction
{

    public function handle()
    {
        $data = $this->event->getData();
        (new FlowCRM())->add($data['dossier'],new ClientDossierNoteCreate($data['user'], $this->params[0]->getValue()));
    }

    public function prepareParams(): array
    {
        return [
            ParamsString::class
        ];
    }

    public function name(): string
    {
        return "Ajouter une note";
    }

    public function describe(): string
    {
        return "Permet d'ajouter une note a la timeline d'un client";
    }
}

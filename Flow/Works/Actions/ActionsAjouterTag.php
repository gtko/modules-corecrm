<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Works\Params\ParamsStatus;
use Modules\CoreCRM\Flow\Works\Params\ParamsTag;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;

class ActionsAjouterTag extends WorkFlowAction
{
    public function handle()
    {
        $data = $this->event->getData();
        app(TagsRepositoryContract::class)->attachDossier($data['dossier'], $this->params[0]->getValue());
    }

    public function prepareParams(): array
    {
        return [
            ParamsTag::class
        ];
    }

    public function name(): string
    {
        return 'Ajouter un tag';
    }

    public function describe(): string
    {
        return "Permet d'ajouter un tag au dossier";
    }
}

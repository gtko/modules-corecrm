<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Works\Params\ParamsStatus;
use Modules\CoreCRM\Flow\Works\Params\ParamsTag;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;

class ActionsSupprimerTag extends WorkFlowAction
{
    public function handle()
    {
        $data = $this->event->getData();
        app(TagsRepositoryContract::class)->detachTag($data['dossier'], $this->params[0]->getValue());
    }

    public function prepareParams(): array
    {
        return [
            ParamsTag::class
        ];
    }

    public function name(): string
    {
        return 'Détacher un tag';
    }

    public function describe(): string
    {
        return "Permet de détacher un tag au dossier";
    }
}

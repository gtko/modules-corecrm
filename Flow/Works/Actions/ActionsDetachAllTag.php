<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Works\Params\ParamsStatus;
use Modules\CoreCRM\Flow\Works\Params\ParamsTag;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;

class ActionsDetachAllTag extends WorkFlowAction
{
    public function handle()
    {
        $data = $this->event->getData();
        $data['dossier']->tags()->detach();
    }

    public function prepareParams(): array
    {
        return [
        ];
    }

    public function name(): string
    {
        return 'Détacher tous les tags';
    }

    public function describe(): string
    {
        return "détacher tous les tags d'un dossier";
    }
}

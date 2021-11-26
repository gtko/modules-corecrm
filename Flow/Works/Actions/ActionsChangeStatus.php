<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Works\Params\ParamsStatus;

class ActionsChangeStatus extends WorkFlowAction
{
    public function handle()
    {
        $data = $this->event->getData();
        app(DossierRepositoryContract::class)
            ->changeStatus($data['dossier'], $this->params[0]->getValue());
    }

    public function prepareParams(): array
    {
        return [
            ParamsStatus::class
        ];
    }

    public function name(): string
    {
        return 'Changer le status';
    }

    public function describe(): string
    {
        return "Permet de changer le status ou la pipeline d'un dossier";
    }
}

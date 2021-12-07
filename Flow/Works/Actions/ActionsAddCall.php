<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\CallCRM\Contracts\Repositories\AppelRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\ClientDossierNoteCreate;
use Modules\CoreCRM\Flow\Works\Params\ParamsString;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsCall;

class ActionsAddCall extends WorkFlowAction
{

    public function handle()
    {
        $data = $this->event->getData();
        $dossier = $data['dossier'];
        $commercial = $data['commercial'];

        $rep = app(AppelRepositoryContract::class);
        $rep->createAppel(
            $commercial->id,
            Auth::user(),
            $dossier,
            Carbon::now()->addHours(24)->startOfHour(),
            false,
            false
        );
    }

    public function prepareParams(): array
    {
        return [
            ParamsCall::class
        ];
    }

    public function name(): string
    {
        return "Ajouter un appel dans 24h";
    }

    public function describe(): string
    {
        return "Permet d'ajouter un appel dans 24h";
    }
}

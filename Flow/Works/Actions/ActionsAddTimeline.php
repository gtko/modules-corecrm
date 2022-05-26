<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\CallCRM\Contracts\Repositories\AppelRepositoryContract;
use Modules\CallCRM\Flow\Attributes\ClientDossierAppelCreate;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\ClientDossierAddTimeline;
use Modules\CoreCRM\Flow\Attributes\ClientDossierNoteCreate;
use Modules\CoreCRM\Flow\Works\Params\ParamsNotification;
use Modules\CoreCRM\Flow\Works\Params\ParamsString;
use Modules\CoreCRM\Flow\Works\Params\ParamsTimeline;
use Modules\CoreCRM\Flow\Works\Variables\WorkFlowParseVariable;
use Modules\CoreCRM\Jobs\SendNotificationWorkFlowJob;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsCall;

class ActionsAddTimeline extends WorkFlowAction
{

    public function getValues(){
        $values = $this->event->getFlow()->override_data[self::class]['data'] ?? $this->params[0]->getValue();
        return $values;
    }

    public function handle()
    {
        $this->sendTimeline();
    }

    public function resolveDatas(){
        return (new WorkFlowParseVariable($this->event, $this->getValues()))->resolve();
    }

    public function sendTimeline(){
        $eventData = $this->event->getData();
        $datas = $this->resolveDatas();
        (new FlowCRM())->add($eventData['dossier'],new ClientDossierAddTimeline($eventData['user'] ?? null, $datas['titre'], $datas['message']));
    }

    protected function prepareParams(): array
    {
        return [
            ParamsTimeline::class
        ];
    }

    public function isVariabled():bool
    {
        return true;
    }

    public function name(): string
    {
        return "Ajouter une card dans la timeline";
    }

    public function describe(): string
    {
        return "Permet d'ajouter une card dans la timeline du dossier";
    }
}

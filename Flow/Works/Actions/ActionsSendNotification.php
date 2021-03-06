<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Modules\CoreCRM\Flow\Works\Params\ParamsNotification;
use Modules\CoreCRM\Flow\Works\Variables\WorkFlowParseVariable;
use Modules\CoreCRM\Jobs\SendNotificationWorkFlowJob;
use Modules\CoreCRM\Mail\WorkFlowStandardMail;

class ActionsSendNotification extends WorkFlowAction
{


    public function getValues(){
       $values = $this->event->getFlow()->override_data[self::class]['data'] ?? $this->params[0]->getValue();
       return $values;
    }

    public function handle()
    {
        $this->sendEmail();
    }

    public function resolveDatas(){
        return (new WorkFlowParseVariable($this->event, $this->getValues()))->resolve();
    }

    public function sendEmail(){
        $datas = $this->resolveDatas();
        $delay = random_int($datas['delay_min'] ?? 0, $datas['delay_max'] ?? 0);

        SendNotificationWorkFlowJob::dispatch($datas, $this->event)
            ->delay(now()->addMinutes($delay));
    }

    public function preview(){
        $datas = $this->resolveDatas();
        return (new SendNotificationWorkFlowJob($datas, $this->event))->maillable()->render();
    }


    public function isVariabled():bool
    {
        return true;
    }

    protected function prepareParams(): array
    {
        return [
            ParamsNotification::class
        ];
    }

    public function name(): string
    {
        return 'Envoyer une notification email';
    }

    public function describe(): string
    {
        return 'Permet de notifier un utilisateur du CRM par tous les canaux disponible email';
    }
}

<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Mail;
use Modules\CoreCRM\Flow\Works\Params\ParamsNotification;
use Modules\CoreCRM\Flow\Works\Variables\WorkFlowParseVariable;
use Modules\CoreCRM\Mail\WorkFlowStandardMail;

class ActionsSendNotification extends WorkFlowAction
{


    public function handle()
    {
        $data = $this->event->getData();

        $parseVariable = new WorkFlowParseVariable($this->event, $this->params[0]->getValue());
        $datas = $parseVariable->resolve();

        $maillable = new WorkFlowStandardMail($datas['subject'], explode(',', $datas['cci']), $datas['content']);
        Mail::to($datas['cc'])
            ->send($maillable);
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

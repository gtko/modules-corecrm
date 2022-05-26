<?php

namespace Modules\CoreCRM\Flow\Works\Actions;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\BaseCore\Models\User;
use Modules\CallCRM\Contracts\Repositories\AppelRepositoryContract;
use Modules\CallCRM\Flow\Attributes\ClientDossierAppelCreate;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\ClientDossierAddTimeline;
use Modules\CoreCRM\Flow\Attributes\ClientDossierNoteCreate;
use Modules\CoreCRM\Flow\Works\Params\ParamsNotification;
use Modules\CoreCRM\Flow\Works\Params\ParamsNotificationPush;
use Modules\CoreCRM\Flow\Works\Params\ParamsString;
use Modules\CoreCRM\Flow\Works\Params\ParamsTimeline;
use Modules\CoreCRM\Flow\Works\Variables\WorkFlowParseVariable;
use Modules\CoreCRM\Jobs\SendNotificationWorkFlowJob;
use Modules\CoreCRM\Notifications\NotificationBase;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsCall;

class ActionsAddNotif extends WorkFlowAction
{

    public function getValues(){
        $values = $this->event->getFlow()->override_data[self::class]['data'] ?? $this->params[0]->getValue();
        return $values;
    }

    public function handle()
    {
        $this->sendNotification();
    }

    public function resolveDatas(){
        return (new WorkFlowParseVariable($this->event, $this->getValues()))->desactiveConvertLinkToButton()->resolve();
    }

    public function sendNotification(){
        $eventData = $this->event->getData();
        $datas = $this->resolveDatas();

        //Formatage des users a qui envoyé la notification
        $emails = explode(',', $datas['email'] ?? '');
        $users = app(UserRepositoryContract::class)->newQuery()
            ->whereHas('personne',function($query) use ($emails){
                $query->whereHas('emails',function($query) use ($emails){
                    $query->whereIn('email',$emails);
                });
            })->get();


        $notification = new NotificationBase($datas);
        foreach($users as $user){
            $user->notify($notification);
        }

    }

    protected function prepareParams(): array
    {
        return [
            ParamsNotificationPush::class
        ];
    }

    public function isVariabled():bool
    {
        return true;
    }

    public function name(): string
    {
        return "Envoyer une notification";
    }

    public function describe(): string
    {
        return "Envoyer une notification dans le CRM a un utilisateur";
    }
}

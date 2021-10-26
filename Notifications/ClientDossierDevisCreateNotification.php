<?php

namespace Modules\CoreCRM\Notifications;

use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisCreate;
use Modules\CoreCRM\Flow\Notification\Notif;
use Modules\BaseCore\Models\User;

class ClientDossierDevisCreateNotification extends Notif
{

    public function listenFlow():array
    {
        return [
            ClientDossierDevisCreate::class
        ];
    }

    public function handle():void
    {
        foreach(User::role(['super-admin'])->get() as $user){
            $user->notify($this);


        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        /** @var ClientDossierDevisCreate $flowAttributes */
        $flowAttributes =  $this->flow->datas;

        return [
            'url' => route('devis.edit', [
                $flowAttributes->getDevis()->dossier->client,
                $flowAttributes->getDevis()->dossier,
                $flowAttributes->getDevis(),
            ]),
            'image' => $flowAttributes->getDevis()->dossier->client->avatar_url,
            'title' => 'Nouveau devis',
            'content' => 'Il y a un nouveau devis pour ' . $flowAttributes->getDevis()->dossier->client->format_name
        ];
    }
}

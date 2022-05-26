<?php

namespace Modules\CoreCRM\Notifications;

use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisCreate;

class NotificationBase extends \Illuminate\Notifications\Notification
{

    public function __construct(
        public array $data
    ){}

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

        return [
            'url' => $this->data['url'],
            'image' => $this->data['image'],
            'title' => $this->data['title'],
            'content' => $this->data['content'],
        ];
    }
}

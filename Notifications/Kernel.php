<?php


namespace Modules\CoreCRM\Notifications;


class Kernel
{
    public static function list():array
    {
        return [
           ClientDossierDevisCreateNotification::class,
        ];
    }
}

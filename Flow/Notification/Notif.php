<?php


namespace Modules\CoreCRM\Flow\Notification;


use Illuminate\Notifications\Notification;
use Modules\CoreCRM\Models\Flow;

abstract class Notif extends Notification
{

    public function __construct(
        public Flow $flow
    ){}

    abstract public function listenFlow():array;
    abstract public function handle():void;

}

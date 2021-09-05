<?php


namespace Modules\CoreCRM\Flow\Notification;


use Illuminate\Support\Facades\Event;
use Modules\CoreCRM\Events\FlowAddEvent;
use Modules\CoreCRM\Models\Flow;
use Modules\CoreCRM\Notifications\Kernel;

class NotificationsDispatch
{
    public function __construct()
    {
        Event::listen(function (FlowAddEvent $event) {
            $observable = get_class($event->flow->datas);
            $listeners = Kernel::list();
            foreach($listeners as $listener){
                $instance = $this->instanceListener($listener, $event->flow);
                if(in_array($observable,$instance->listenFlow())) {
                    $instance->handle();
                }
            }
        });
    }

    private function instanceListener(string $listener, Flow $flow): Notif
    {
          return new $listener($flow);
    }
}

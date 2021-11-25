<?php

namespace Modules\CoreCRM\Flow\Works;

use Illuminate\Support\Facades\Event;
use Modules\CoreCRM\Contracts\Repositories\WorkflowRepositoryContract;
use Modules\CoreCRM\Events\FlowAddEvent;
use Modules\CoreCRM\Flow\Notification\Notif;
use Modules\CoreCRM\Flow\Works\Events\EventClientDossierCreate;
use Modules\CoreCRM\Flow\Works\Events\EventClientDossierDevisCreate;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Models\Flow;
use Modules\CoreCRM\Notifications\Kernel;

class WorkflowKernel
{

    protected array $storeEvent = [
        EventClientDossierCreate::class,
        EventClientDossierDevisCreate::class
    ];

    private function instanceActions(string $actions, Flow $flow): Notif
    {
        return new $actions($flow);
    }

    private function instanceEvent(string $event): WorkFlowEvent
    {
        return new $event();
    }

    public function dispatch(){
        $workflows = app(WorkflowRepositoryContract::class)->newQuery()->get();

        Event::listen(function (FlowAddEvent $event) use ($workflows){

            $observable = get_class($event->flow->datas);
            $listeners = [];
            foreach($workflows as $workflow){
                if($workflow->active){
                    $listeners[collect($workflow->events)->pluck('class')->first()] = $workflow;
                }
            }

            foreach ($listeners as $workFlowEventClass => $workflow) {
                $instance = $this->instanceEvent($workFlowEventClass);
                if (in_array($observable, $instance->listen())) {
                    $instance->init($event->flow);
                    foreach($workflow->actions as $action) {
                        $instanceAction = $instance->makeAction($action['class']);
                        $instanceAction->initParams($action['params']);
                        $instanceAction->handle();
                    }
                }
            }

        });

        //@todo on resolve les events entrant suivant les workflow en bdd et actif
    }

    public function addEvent(WorkFlowEvent $event){
        if(!in_array($event::class, $this->storeEvent, true)) {
            $this->storeEvent[] = $event::class;
        }
    }

    public function addEvents(array $events){
        foreach($events as $event){
            $this->addEvent(new($event));
        }
    }

    /**
     * @return WorkFlowEvent[]
     */
    public function getEvents():array
    {
        return $this->storeEvent;
    }

}

<?php

namespace Modules\CoreCRM\Flow\Works;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Modules\CoreCRM\Contracts\Repositories\WorkflowRepositoryContract;
use Modules\CoreCRM\Events\FlowAddEvent;
use Modules\CoreCRM\Flow\Notification\Notif;
use Modules\CoreCRM\Flow\Works\Events\EventClientDossierCreate;
use Modules\CoreCRM\Flow\Works\Events\EventClientDossierDevisCreate;
use Modules\CoreCRM\Flow\Works\Events\EventClientDossierDevisUpdate;
use Modules\CoreCRM\Flow\Works\Events\EventClientDossierNoteCreate;
use Modules\CoreCRM\Flow\Works\Events\EventClientDossierUpdate;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Models\Flow;
use Modules\CoreCRM\Models\Workflow;
use Modules\CoreCRM\Notifications\Kernel;
use Modules\CrmAutoCar\Flow\Attributes\CreateProformatClient;

class WorkflowKernel
{

    protected array $storeEvent = [
        EventClientDossierCreate::class,
        EventClientDossierDevisCreate::class,
        EventClientDossierDevisUpdate::class,
        EventClientDossierNoteCreate::class,
        EventClientDossierUpdate::class
    ];

    private function instanceActions(string $actions, Flow $flow): Notif
    {
        return new $actions($flow);
    }

    private function instanceEvent(string $event): WorkFlowEvent
    {
        return new $event();
    }



    public function listenEvents($observableClass):Collection
    {
        $actives = collect();
        $workflows = app(WorkflowRepositoryContract::class)->newQuery()->get();
        $listeners = [];
        foreach($workflows as $workflow){
            if($workflow->active){
                $listeners[] = [
                    'event' => collect($workflow->events)->pluck('class')->first(),
                    'workflow' => $workflow
                ];
            }
        }

        foreach ($listeners as $listen) {
            $workFlowEventClass = $listen['event'];
            $workflow = $listen['workflow'];
            $instance = $this->instanceEvent($workFlowEventClass);
            if (in_array($observableClass, $instance->listen())){
                $actives->push(['instance' => $instance, 'workflow' => $workflow]);
            }
        }

        return $actives;
    }

    public function isConditionValid(WorkFlowEvent $instance, Workflow $workflow){
        $valid = true;
        if(count($workflow->conditions) > 0){
            foreach($workflow->conditions as $condition) {
                app(WorkflowLog::class)->SetMessage("conditions  " . $condition['class']. ' ' .$condition['condition']  . ' target ' . $condition['value']);
                $instanceCondition = $instance->makeCondition($condition['class']);
                $instanceCondition->initTarget($condition['value']);
                if(!$instanceCondition->resolve($condition['condition'])){
                    app(WorkflowLog::class)->SetMessage("conditions  " . $condition['class']. ' faux ');
                    $valid = false;
                }else{
                    app(WorkflowLog::class)->SetMessage("conditions  " . $condition['class']. ' vrai ');
                }
            }
        }

        return $valid;
    }

    public function executeAction(WorkFlowEvent $instance, Workflow $workflow){
        foreach ($workflow->actions as $action) {
            try {
                $instanceAction = $instance->makeAction($action['class']);
                $instanceAction->initParams($action['params']);
                $instanceAction->handle();
            }catch (\Exception $e) {
                app(WorkflowLog::class)->SetActions('error');
            }
        }
        app(WorkflowLog::class)->SetActions('ok');
    }

    public function dispatch(){
        Event::listen(function (FlowAddEvent $event){
            $observable = get_class($event->flow->datas);

            foreach($this->listenEvents($observable) as $listen){
                $workflow = $listen['workflow'];
                /** @var WorkFlowEvent $instance */
                $instance = $listen['instance'];

                app(WorkflowLog::class)->create($event, $workflow, Auth::user() ?? null, []);

                try {
                    //Injection des data dans l'event du workflow pour résoudre les conditions et les actions
                    app(WorkflowLog::class)->SetStatus('nok');
                    app(WorkflowLog::class)->SetMessage("Lancement de l'initialisation du workflow");
                    $instance->init($event->flow);

                    app(WorkflowLog::class)->SetConditions('error');
                    app(WorkflowLog::class)->SetMessage("Validation de la condition du workflow");
                    $valid = $this->isConditionValid($instance, $workflow);
                    if ($valid) {
                        app(WorkflowLog::class)->SetConditions('ok');
                        app(WorkflowLog::class)->SetMessage("Execution des actions");
                        $this->executeAction($instance, $workflow);
                    } else {
                        app(WorkflowLog::class)->SetMessage("Conditions non validées");
                        app(WorkflowLog::class)->SetConditions('nok');
                    }

                    app(WorkflowLog::class)->SetStatus('ok');
                    app(WorkflowLog::class)->SetMessage("Workflow terminé");
                }catch(\Exception $e){
                    app(WorkflowLog::class)->SetStatus('error');
                    app(WorkflowLog::class)->SetMessage('Erreur du workflow ' . $e->getMessage());
                }
            }
        });
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

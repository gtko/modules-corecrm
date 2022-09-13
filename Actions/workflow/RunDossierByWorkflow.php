<?php

namespace Modules\CoreCRM\Actions\workflow;

use Modules\CoreCRM\Events\FlowAddEvent;
use Modules\CoreCRM\Flow\Attributes\SheduleAttribute;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Models\Flow;

class RunDossierByWorkflow
{

    protected $logCallable = null;
    protected $log = [];

    public function log($message){
        if($this->logCallable){
            $this->log[] = $message;
            call_user_func($this->logCallable, $message);
        }
    }

    public function handle($dossiers, $actives,$simulate = true,  $logCallable = null){

        $this->logCallable = $logCallable;

        $runnable = collect();

        foreach ($dossiers as $dossier) {

            foreach($dossier->devis as $devis) {
                $this->log = [];
                if($devis->validate) {
                    $flow = new Flow();
                    $flow->datas = new SheduleAttribute($dossier, $devis);
                    $event = new FlowAddEvent($flow);

                    foreach ($actives as $listen) {

                        $workflow = $listen['workflow'];
                        /** @var WorkFlowEvent $instance */
                        $instance = $listen['instance'];

                        try {
                            $instance->init($event->flow);

                            $valid = true;
                            if (count($workflow->conditions) > 0) {
                                foreach ($workflow->conditions as $condition) {
                                    $instanceCondition = $instance->makeCondition($condition['class']);
                                    $instanceCondition->initTarget($condition['value']);
                                    $this->log("conditions  " . $condition['class'] . ' ' . $condition['condition'] . ' target ' . $condition['value']);
                                    if (!$instanceCondition->resolve($condition['condition'])) {
                                        $valid = false;
                                    }
                                }
                            }

                            $this->log('Dossier ' . $dossier->ref . ' valid : ' . (($valid) ? 'Oui' : 'Non'));

                            if ($valid) {
                                foreach ($workflow->actions as $action) {
                                    try {
                                        if(!$simulate) {
                                            $instanceAction = $instance->makeAction($action['class']);
                                            $instanceAction->initParams($action['params']);
                                            $instanceAction->handle();
                                        }
                                        $this->log('Action ' . $action['class'] . ' effectuée');
                                        $runnable->push([
                                            'execute' => true,
                                            'dossier' => $dossier,
                                            'devis' => $devis,
                                            'log' => $this->log
                                        ]);
                                    } catch (\Exception $e) {
                                        $this->log($e->getMessage());
                                    }
                                }
                            } else {
                                $this->log('Aucune action effectuée');
                                $runnable->push([
                                    'execute' => false,
                                    'dossier' => $dossier,
                                    'devis' => $devis,
                                    'log' => $this->log
                                ]);
                            }

                        } catch (\Exception $e) {
                            $this->log($e->getMessage());
                        }
                    }
                }
            }
        }

        return $runnable;
    }

}

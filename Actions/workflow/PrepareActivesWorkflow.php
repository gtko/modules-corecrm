<?php

namespace Modules\CoreCRM\Actions\workflow;

class PrepareActivesWorkflow
{


    public function handle($workflows){
        $actives = collect();
        foreach($workflows as $workflow){
            $workFlowEventClass = collect($workflow->events)->pluck('class')->first();
            $instance = new $workFlowEventClass;
            $actives->push(['instance' => $instance, 'workflow' => $workflow]);
        }

        return $actives;
    }

}

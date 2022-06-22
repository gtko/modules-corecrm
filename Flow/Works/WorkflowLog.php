<?php

namespace Modules\CoreCRM\Flow\Works;

use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Events\FlowAddEvent;
use Modules\CoreCRM\Models\Workflow;

class WorkflowLog
{

    protected \Modules\CoreCRM\Models\WorkflowLog $workflowLog;

    public function create(FlowAddEvent $event, ?Workflow $workflow = null, ?UserEntity $user = null, array $data = []){

        $flow = $event->flow;

        $this->workflowLog = new \Modules\CoreCRM\Models\WorkflowLog();
        $this->workflowLog->flow_id = $flow->id ?? null;
        $this->workflowLog->workflow_id = $workflow->id ?? null;
        $this->workflowLog->user_id = $user->id ?? null;
        $this->workflowLog->data = $data;
        $this->workflowLog->message = "Création du workflow \n";
        $this->workflowLog->save();

        return $this->workflowLog;

    }

    public function updateData(array $data){
        $oldData = $this->workflowLog->data;
        $newData = array_merge($oldData, $data);
        $this->workflowLog->data = $newData;
        $this->workflowLog->save();
    }


    public function SetConditions(string $status){
        $this->workflowLog->conditions = $status;
        $this->workflowLog->save();
    }

    public function SetActions(string $status){
        $this->workflowLog->actions = $status;
        $this->workflowLog->save();
    }

    public function SetStatus(string $status){
        $this->workflowLog->status = $status;
        $this->workflowLog->save();
    }

    public function SetMessage(string $message){
        $this->workflowLog->message .= $message . "\n";
        $this->workflowLog->save();
    }

}

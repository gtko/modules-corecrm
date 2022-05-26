<?php

namespace Modules\CoreCRM\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddCall;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNote;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNotif;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddTimeline;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Actions\ActionsDetachAllTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSupprimerTag;
use Modules\CoreCRM\Flow\Works\Actions\WorkFlowAction;
use Modules\CoreCRM\Flow\Works\CategoriesEventEnum;
use Modules\CoreCRM\Flow\Works\Conditions\WorkFlowCondition;
use Modules\CoreCRM\Flow\Works\Interfaces\WorkFlowDescribe;
use Modules\CoreCRM\Models\Flow;

abstract class WorkFlowEvent implements WorkFlowDescribe
{

    protected Flow $flow;
    protected array $data = [];


    abstract protected function prepareData(Attributes $flowAttribute):array;
    abstract public function listen():array;

    public function actions(): array
    {
        return [
            ActionsChangeStatus::class,
            ActionsAjouterTag::class,
            ActionsSupprimerTag::class,
            ActionsSendNotification::class,
            ActionsAddNote::class,
            ActionsAddCall::class,
            ActionsAddTimeline::class,
            ActionsAddNotif::class,
            ActionsDetachAllTag::class
        ];
    }


    public function category():string
    {
        return CategoriesEventEnum::OTHER;
    }

    public function conditions():array
    {
        return [

        ];
    }

    public function variables():array
    {
        return [];
    }

    public function files():array
    {
        return [];
    }

    public function init(Flow $flow){
        $flow->datas->setModel($flow);
        $this->flow = $flow;
        $this->data = $this->prepareData($flow->datas);
    }

    public function getFlow()
    {
        return $this->flow;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function makeAction($class):?WorkFlowAction
    {
        try {
            $actions = $this->actions();
            return new ($actions[array_search($class, $actions, true)])($this);
        }catch(\Exception $e){

        }

        return null;
    }

    public function makeCondition($class):?WorkFlowCondition
    {
        try {
            $actions = $this->conditions();
            return new ($actions[array_search($class, $actions, true)])($this);
        }catch(\Exception $e){

        }

        return null;
    }

    public function getVariablesAutoComplete():array
    {
        $variableData = [];
        foreach ($this->variables() as $variable) {
            foreach ($variable->labels() as $label => $description) {
                $variableData[] = [
                    "value" => $variable->namespace() . '.' . \Illuminate\Support\Str::slug($label),
                    "label" => $variable->namespace() . '.' . "$label - $description",
                    'title' => $label,
                    "description" => $description,
                ];
            }
        }

        return $variableData;
    }

}

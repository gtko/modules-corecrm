<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\WorkflowKernel;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;

class MiddlewareWorkFlowEmail extends Component
{

    public $observableEvent = '';

    public $actionData = [];

    public function mount($observable){
       $this->observableEvent = $observable;
    }

    public function render()
    {
        //on intercept l'event ici pour précalculer l'email , et le modifier dans une modal
        $kernel = new WorkflowKernel();
        $events =  $kernel->listenEvents($this->observableEvent);

        $event = $events->first();
        $action = collect($event['workflow']->actions)->where('class', ActionsSendNotification::class)->first();
        $this->actionData = $action['params'][0];
        $actionInstance = $event['instance']->makeAction(ActionsSendNotification::class);

        $param = $actionInstance->params()[0];

        $variableData = [];
        if($action['class'] ?? false){
            if($actionInstance->isVariabled()){
                foreach($event['instance']->variables() as $variable){
                    foreach($variable->labels() as $label => $description){
                        $variableData[] = [
                            "value" => $variable->namespace().'.'.\Illuminate\Support\Str::slug($label),
                            "label" => $variable->namespace().'.'."$label - $description",
                        ];
                    }
                }
            }
        }

        return view('corecrm::livewire.middleware-work-flow-email',
            compact('actionInstance', 'param', 'variableData'));
    }
}

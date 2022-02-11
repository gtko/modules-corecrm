<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\WorkflowKernel;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;

class MiddlewareWorkFlowEmail extends Component
{

    public $observableEvent = '';
    public $callback = '';

    public $actionData = [];
    public $variableData = [];

    public function mount($observable, $callback){
       $this->observableEvent = $observable;
       $this->callback = $callback;
    }

    public function send(){

        $kernel = new WorkflowKernel();
        $events =  $kernel->listenEvents($this->observableEvent);

        $event = $events->first();
        $action = collect($event['workflow']->actions)->where('class', ActionsSendNotification::class)->first();

        $this->emit($this->callback, ['data' => $this->actionData]);

    }

    public function render()
    {
        //on intercept l'event ici pour précalculer l'email , et le modifier dans une modal
        $kernel = new WorkflowKernel();
        $events =  $kernel->listenEvents($this->observableEvent);

        $event = $events->first();
        $action = collect($event['workflow']->actions)->where('class', ActionsSendNotification::class)->first();
        if(empty($this->actionData)){
            $this->actionData = $action['params'][0];
        }
        $actionInstance = $event['instance']->makeAction(ActionsSendNotification::class);

        $param = $actionInstance->params()[0];

        if(empty($this->variableData)) {
            $this->variableData = [];
            if ($action['class'] ?? false) {
                if ($actionInstance->isVariabled()) {
                    foreach ($event['instance']->variables() as $variable) {
                        foreach ($variable->labels() as $label => $description) {
                            $this->variableData[] = [
                                "value" => $variable->namespace() . '.' . \Illuminate\Support\Str::slug($label),
                                "label" => $variable->namespace() . '.' . "$label - $description",
                            ];
                        }
                    }
                }
            }
        }

        return view('corecrm::livewire.middleware-work-flow-email',
            compact('actionInstance', 'param'));
    }
}

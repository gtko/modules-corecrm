<?php

namespace Modules\CoreCRM\Http\Livewire;

use Illuminate\Mail\Markdown;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\Variables\WorkFlowParseVariable;
use Modules\CoreCRM\Flow\Works\WorkflowKernel;
use Modules\CoreCRM\Mail\WorkFlowStandardMail;
use Modules\CoreCRM\Models\Flow;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;

class MiddlewareWorkFlowEmail extends Component
{

    public $observableEvent = '';
    public $callback = '';
    public $flowable = [];

    public $actionData = [];
    public $variableData = [];

    public $preview = false;


    public function mount($flowable, $observable,$callback = null){
       $this->observableEvent = $observable;
       $this->callback = $callback;
       $this->flowable = $flowable;
    }


    protected function getInstanceAttributeEvent(){
        return $this->observableEvent[0][0]::instance($this->observableEvent[0][1]);
    }

    public function send(){
        $kernel = new WorkflowKernel();
        $events =  $kernel->listenEvents($this->observableEvent[0][0]);

        $event = $events->first();
        $action = collect($event['workflow']->actions)->where('class', ActionsSendNotification::class)->first();

        foreach($this->observableEvent as $observable) {
            app(FlowContract::class)->add(
                app($this->flowable[0])::find($this->flowable[1]),
                $observable[0]::instance($observable[1]),
                [
                    ActionsSendNotification::class => ['data' => $this->actionData]
                ]
            );
        }

        $this->emit($this->callback, ['data' => $this->actionData]);
    }

    public function preview(){
        $this->preview = true;
    }

    public function editer(){
        $this->preview = false;
    }

    public function getEmailProperty(){

        $kernel = new WorkflowKernel();
        $events =  $kernel->listenEvents($this->observableEvent[0][0]);
        $event = $events->first();

        $attribute =  $this->getInstanceAttributeEvent();


        $flow = new Flow();
        $flow->datas = $attribute;
        $event['instance']->init($flow);

        $parseVariable = new WorkFlowParseVariable($event['instance'], $this->actionData);
        $datas = $parseVariable->resolve();

        $maillable = new WorkFlowStandardMail(
            $datas['subject'],
            $datas['cci'] ?? '',
            $datas['content'],
            [],
            $datas['template'] ?? 'default'
        );

        return $maillable->render();
    }

    public function render()
    {
        //on intercept l'event ici pour précalculer l'email , et le modifier dans une modal
        $kernel = new WorkflowKernel();
        $events =  $kernel->listenEvents($this->observableEvent[0][0]);

        $event = $events->first();

        if($event === null){
            dd("Le worflow n'existe pas !", $this->observableEvent[0][0]);
        }


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

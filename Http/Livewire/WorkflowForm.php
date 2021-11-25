<?php

namespace Modules\CoreCRM\Http\Livewire;

use Illuminate\Support\Arr;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\WorkflowRepositoryContract;
use Modules\CoreCRM\Flow\Works\Interfaces\TypeDataSelect;
use Modules\CoreCRM\Flow\Works\WorkflowKernel;
use Modules\CoreCRM\Models\Workflow;

class WorkflowForm extends Component
{

    public $workflow;

    public $data = [
        'name' => '',
        'description' => '',
        'events' => [],
        'conditions' => [],
        'actions' => [
            [
            'class' => '',
            'params' => []
            ]
        ],
    ];

    public $edition = false;

    protected $rules = [
        'data.*' => ''
    ];

    public function mount(?Workflow $workflow)
    {
        $this->workflow = $workflow;
        if($this->workflow->id ?? null) {
            $this->edition = true;
            $this->data = $this->workflow->toArray();
        }else{
            $this->data = [
                'name' => '',
                'description' => '',
                'events' => [['class' => '']],
                'conditions' => [],
                'actions' => [
                    [
                        'class' => '',
                        'params' => []
                    ]
                ],
            ];
        }
    }

    public function updatedData($value, $key){

        if($key === 'events.0.class'){
            $this->data['actions'] = [[
                'class' => '',
                'params' => []
            ]];
        }

    }


    public function addEvent(){
            $this->data['events'][] = [
                'class' => ''
            ];
    }

    public function addCondition(){
        $this->data['conditions'][] = [
            'class' => '',
            'field' => '',
            'condition' => '',
            'value' => ''
        ];
    }

    public function addAction(){
        $this->data['actions'][] = [
            'class' => '',
            'params' => []
        ];
    }

    public function store(WorkflowRepositoryContract $workflowRep){

        if($this->edition){
            $workflowRep->update(
                $this->workflow,
                $this->data['name'],
                $this->data['description'],
                $this->data['events'],
                $this->data['conditions'],
                $this->data['actions']
            );
        }else{
            $workflowRep->create(
                $this->data['name'],
                $this->data['description'],
                $this->data['events'],
                $this->data['conditions'],
                $this->data['actions']
            );
        }

        return redirect()->route('workflows.index');
    }

    public function render(WorkflowKernel $workflowKernel)
    {
        $kernelEvents = $workflowKernel->getEvents();
        return view('corecrm::livewire.workflow-form', compact('kernelEvents'));
    }
}

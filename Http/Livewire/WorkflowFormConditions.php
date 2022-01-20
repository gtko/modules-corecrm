<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;

class WorkflowFormConditions extends Component
{

    public $data = [];

    public $listeners = [
        'deleteCondition' => 'deleteCondition',
    ];

    public function mount($data){
        $this->data = $data;
    }

    public function updateEvent($data)
    {
        $this->data = $data;
        $this->emit('workflowUpdated', $this->data);
    }

    public function addCondition(){
        $this->data['conditions'][] = [
            'class' => '',
            'field' => '',
            'condition' => '',
            'value' => ''
        ];

        $this->emit('workflowUpdated', $this->data);
    }

    public function deleteCondition($index){
        unset($this->data['conditions'][$index]);
        $this->emit('workflowUpdated', $this->data);
    }

    public function render()
    {
        return view('corecrm::livewire.workflow-form-conditions');
    }
}

<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;

class WorkflowFormConditionsItem extends Component
{

    public $data;
    public $index;

    public function mount($data, $index){
        $this->data = $data;
        $this->index = $index;
    }

    public function deleteCondition($index){
        $this->emit('deleteCondition', $index);
    }

    public function render()
    {
        return view('corecrm::livewire.workflow-form-conditions-item');
    }
}

<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;

class WorkflowFormActionItem extends Component
{
    public $data;
    public $index;

    public function mount($data, $index){
        $this->data = $data;
        $this->index = $index;
    }

    public function updated(){
        $this->emit('workflowUpdated', $this->data);
    }

    public function deleteAction(){
        $this->emit('workflowActionDeleted', $this->index);
    }

    public function render()
    {
        return view('corecrm::livewire.workflow-form-action-item');
    }
}

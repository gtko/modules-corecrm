<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;
use Modules\TaskCalendarCRM\Models\Task;

class DossierTasksItem extends Component
{
    public $task;

    public function mount(Task $task){
        $this->task = $task;
    }

    public function important(){
        $data = $this->task->data;
        $data['important'] = !($data['important'] ?? false);
        $this->task->data = $data;
        $this->task->save();
    }

    public function checked(){
        $this->task->checked = true;
        $this->task->save();
    }

    public function render()
    {
        return view('corecrm::livewire.dossier-tasks-item');
    }
}

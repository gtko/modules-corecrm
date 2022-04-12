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
        if($this->task->data['uuid'] ?? false){
            $tasks  = Task::where('data->uuid', $this->task->data['uuid'])->get();
            foreach($tasks as $task){
                $task->checked = true;
                $task->save();
            }
        }else {
            $this->task->checked = true;
            $this->task->save();
        }
        $this->emit('taskChecked');

    }

    public function appel($state){

        if($this->task->data['uuid'] ?? false){
            $tasks  = Task::where('data->uuid', $this->task->data['uuid'])->get();
            foreach($tasks as $task){
                $data = $task->data;
                $data['appel'] = $state;
                $task->data = $data;
                $task->checked = true;
                $task->save();
            }
        }else {
            $data = $this->task->data;
            $data['appel'] = $state;
            $this->task->data = $data;
            $this->task->checked = true;
            $this->task->save();
        }

        $this->emit('taskChecked');
    }

    public function render()
    {
        return view('corecrm::livewire.dossier-tasks-item');
    }
}

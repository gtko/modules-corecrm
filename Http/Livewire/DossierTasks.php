<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Models\Dossier;
use Modules\TaskCalendarCRM\Contracts\Repositories\TaskRepositoryContract;

class DossierTasks extends Component
{


    public $dossier;

    protected $listeners = [
        'taskChecked' => '$refresh',
    ];

    public function mount(Dossier $dossier){
        $this->dossier = $dossier;
    }


    public function refresh(){
        $this->emit('$refresh');
    }


    public function render()
    {

        $tasks = app(TaskRepositoryContract::class)
            ->newQuery()
            ->where('url', route('dossiers.show', [$this->dossier->client, $this->dossier]))
            ->where('checked', false)
            ->get();

        return view('corecrm::livewire.dossier-tasks', compact('tasks'));
    }
}

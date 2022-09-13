<?php

namespace Modules\CoreCRM\Http\Livewire;

use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\CoreCRM\Actions\workflow\PrepareActivesWorkflow;
use Modules\CoreCRM\Actions\workflow\RunDossierByWorkflow;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Document as ModelDocument;
use Modules\CoreCRM\Models\Dossier;

class WorkflowSimulate extends Component
{

    public $state = 'wait';
    public $runnables = [];

    protected $listeners = ['launchSimulate' => 'simulate'];

    public function mount($workflow)
    {
        $this->workflow = $workflow;
    }

    public function launchSimulate(){
        $this->state ='processing';
        $this->emit('launchSimulate');
    }

    public function simulate()
    {
            $workflows = collect([$this->workflow]);
            $actives = (new PrepareActivesWorkflow())->handle($workflows);

            $dossiers = \Modules\CrmAutoCar\Models\Dossier::whereHas('status', function ($query) {
                $query->where('type', StatusTypeEnum::TYPE_CUSTOM);
            })->get();

            $this->runnables = (new RunDossierByWorkflow())->handle($dossiers, $actives, true , function($message){
                //rien
            });

            $this->state = 'done';
    }

    public function render()
    {
        return view('corecrm::livewire.workflow-simulate');
    }
}

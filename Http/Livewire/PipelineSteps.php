<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Status;

class PipelineSteps extends Component
{

    public $dossier;

    public function mount(Dossier $dossier)
    {
        $this->dossier = $dossier;
    }

    public function change(DossierRepositoryContract $dossierRep, StatusRepositoryContract $statusRep,  $status_id)
    {
        $dossierRep->changeStatus($this->dossier,$statusRep->getById($status_id));
    }

    public function render()
    {
        $status = $this->dossier->status;
        $pipeline = $status->pipeline;
        return view('corecrm::livewire.pipeline-steps', compact('pipeline', 'status'));
    }
}

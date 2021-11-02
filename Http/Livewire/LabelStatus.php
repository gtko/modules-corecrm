<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;

class LabelStatus extends Component
{
    public $dossier;
    public $statusSelect;

    protected $rules = [
        'statusSelect' => 'required'
        ];

    public function mount($dossier)
    {

        $this->dossier = $dossier;
    }

    public function change()
    {
        $this->validate();
       $repStatus = app(StatusRepositoryContract::class);
       $status = $repStatus->fetchById($this->statusSelect);
       app(DossierRepositoryContract::class)->changeStatus($this->dossier, $status);
       $this->statusSelect = '';
       $this->emit('refresh');
    }

    public function render()
    {
        $statusList = app(StatusRepositoryContract::class)->fetchAll();
        return view('corecrm::livewire.label-status', compact(['statusList']));
    }
}

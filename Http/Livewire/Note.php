<?php

namespace Modules\CoreCRM\Http\Livewire;


use Auth;
use Livewire\Component;
use Modules\CoreCRM\Flow\Attributes\ClientDossierNoteCreate;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Services\FlowCRM;

class Note extends Component
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */

    public $note;
    public $dossier;
    public $dossier_id;
    public $client_id;

    public function mount($dossierId, $clientId)
    {

        $this->dossier_id = $dossierId;
        $this->client_id = $clientId;

        $this->dossier = Dossier::find($dossierId);
    }

    public function store()
    {
        (new FlowCRM())->add($this->dossier,new ClientDossierNoteCreate(Auth::user(), $this->note));

        return redirect()->to('/clients/' . $this->client_id . '/dossiers/' . $this->dossier_id);
    }

    public function render()
    {
        return view('corecrm::livewire.note');
    }

}

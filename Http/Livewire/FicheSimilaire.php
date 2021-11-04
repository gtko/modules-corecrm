<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Models\Dossier;

class FicheSimilaire extends Component
{

    public $dossier;
    public $selectDossier;

    public function mount(Dossier $dossier){
        $this->dossier = $dossier;
        $this->selectDossier = $this->dossier->id;
    }

    public function updatingSelectDossier($id){
        if($this->selectDossier !== $id){
            return $this->redirect(route('dossiers.show', [$this->dossier->client, $id]));
        }
    }

    public function render()
    {
        $dossiers = $this->dossier->client->dossiers()->where('id', '!=', $this->dossier->id)->get();

        return view('corecrm::livewire.fiche-similaire', compact('dossiers'));
    }
}

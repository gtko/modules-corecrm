<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Models\Dossier;

class DossierNoteGlobal extends Component
{

    public $dossier;
    public $note_global;

    public function mount(Dossier $dossier){
        $this->dossier = $dossier;
        $this->note_global = $dossier->data['note_global'] ?? '';
    }

    public function store(){
        $data = $this->dossier->data;
        $data['note_global'] = $this->note_global;
        $this->dossier->data = $data;
        $this->dossier->save();
    }

    public function render()
    {
        return view('corecrm::livewire.dossier-note-global');
    }
}

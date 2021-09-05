<?php

namespace Modules\CoreCRM\Http\Livewire;

use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Document as ModelDocument;
use Modules\CoreCRM\Models\Dossier;

class Document extends Component
{
    use WithFileUploads;

    public $file, $title, $client, $dossier;

    protected $rules = [
        'file' => 'required',
        'title' => 'required'
    ];

    public function mount($dossierId, $clientId)
    {
        $this->client = Client::find($clientId);
        $this->dossier = Dossier::find($dossierId);
    }


    public function store()
    {
        $this->validate();

        $path = $this->file->store('documents', 'public');

        $document = new ModelDocument();
        $document->dossier()->associate($this->dossier);
        $document->user()->associate(Auth::user());
        $document->name = $this->title;
        $document->path = $path;
        $document->save();

        $this->reset(['title', 'file']);

        $this->emit('documentAdd');


    }

    public function render()
    {
        return view('corecrm::livewire.document');
    }
}

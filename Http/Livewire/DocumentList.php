<?php

namespace Modules\CoreCRM\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\CoreCRM\Models\Document as ModelDocument;

class DocumentList extends Component
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public $documents, $dossier_id;
    protected $listeners = ['documentAdd' => '$refresh'];

    public function mount($dossierId)
    {
       $this->dossier_id = $dossierId;
    }

    public function download($documentId)
    {
        $document = ModelDocument::find($documentId);
        return Storage::download('public/' . $document->path);
    }

    public function delete($documentId)
    {
        $document = ModelDocument::find($documentId);
        $document->delete();
    }

    public function render()
    {
        if(Auth::user()->can('viewAny', \Modules\CoreCRM\Models\Document::class)) {
            $this->documents = ModelDocument::where('dossier_id', $this->dossier_id)->get();
        }

        $this->documents = [];

        return view('corecrm::livewire.document-list');
    }


}

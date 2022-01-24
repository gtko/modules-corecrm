<?php

namespace Modules\CoreCRM\View\Components\Timeline;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Modules\CoreCRM\Models\Dossier;


class ClientDossierNoteCreate extends TimelineComponent
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(): ?View
    {
        if(Auth::user()->can('viewNote', \Modules\CoreCRM\Models\Dossier::class)) {
            return view('corecrm::components.timeline.client.dossier.note.create');
        }

        return null;
    }
}

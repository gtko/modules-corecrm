<?php

namespace Modules\CoreCRM\View\Components\Timeline;

use Illuminate\View\View;

class ClientDossierUpdate extends TimelineComponent
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(): View
    {
        return view('corecrm::components.timeline.client.dossier.update');
    }
}

<?php

namespace Modules\CoreCRM\View\Components\Timeline;

use Illuminate\View\View;
use Modules\CoreCRM\View\Components\Timeline\TimelineComponent;


class ClientDossierAddTimeline extends TimelineComponent
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('corecrm::components.timeline.client.dossier.add.timeline');
    }
}

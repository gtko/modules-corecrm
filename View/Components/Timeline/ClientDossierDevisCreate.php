<?php


namespace Modules\CoreCRM\View\Components\Timeline;


use Illuminate\View\View;

class ClientDossierDevisCreate extends TimelineComponent
{

    function render(): View
    {
        return view('corecrm::components.timeline.client.dossier.devis.create');
    }
}

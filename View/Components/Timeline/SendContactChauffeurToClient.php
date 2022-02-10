<?php


namespace Modules\CoreCRM\View\Components\Timeline;


use Illuminate\View\View;


class SendContactChauffeurToClient extends TimelineComponent
{

    function render(): View
    {
        return view('corecrm::components.timeline.send-contact-chauffeur-to-client');
    }
}

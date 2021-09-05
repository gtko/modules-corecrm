<?php

namespace Modules\CoreCRM\View\Components;

use Illuminate\View\Component;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;

class LinkDevis extends Component
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */

    public string $link;

    public function __construct(DevisEntities $devis)
    {
        $this->link = (new GenerateLinkDevis())->GenerateLink($devis);
    }

    public function render()
    {
        return view('corecrm::components.link-devis');
    }


}

<?php

namespace Modules\CoreCRM\View\Components\Client;

use Illuminate\View\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Client;

class ClientForm extends Component
{

    public function __construct(
        public ?ClientEntity $client = null
    ){}

    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('corecrm::components.client.form');
    }
}

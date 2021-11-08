<?php

namespace Modules\CoreCRM\View\Components\Client;

use Illuminate\View\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;

class ClientSidebar extends Component
{

    public function __construct(
        public ClientEntity $client

    ){

    }


    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        return view('corecrm::components.client.sidebar');
    }
}

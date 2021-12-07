<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Modules\CoreCRM\Models\Commercial;

class ClientVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'client';
    }

    public function data(): array
    {
       /** @var \Modules\CoreCRM\Contracts\Entities\ClientEntity $client */
        $client = $this->event->getData()['client'];

        return [
          'email' => $client->email,
          'phone' => $client->phone,
          'nom et prénom' => $client->format_name,
          'adresse' => $client->full_address,
        ];
    }

    public function labels(): array
    {
        return [
            'nom et prénom' => 'Nom et prénom',
            'email' => 'Email',
            'phone' => 'Numéro de téléphone',
            'adresse' => 'Adresse postal'
        ];
    }
}

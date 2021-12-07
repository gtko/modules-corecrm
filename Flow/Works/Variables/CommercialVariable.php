<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Modules\CoreCRM\Models\Commercial;

class CommercialVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'commercial';
    }

    public function data(): array
    {
       /** @var Commercial $commercial */
        $commercial = $this->event->getData()['commercial'];

        return [
          'id' => $commercial->id,
          'email' => $commercial->email,
          'phone' => $commercial->phone,
          'full name' => $commercial->format_name,
        ];
    }

    public function labels(): array
    {
        return [
            'id' => 'id du commercial',
            'full name' => 'Nom et prénom du commercial',
            'email commercial' => 'Email du commercial',
            'phone' => 'Numéro de téléphone du commercial'

        ];
    }
}

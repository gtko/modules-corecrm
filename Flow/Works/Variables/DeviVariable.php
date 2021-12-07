<?php

namespace Modules\CoreCRM\Flow\Works\Variables;



use Modules\DevisAutoCar\Models\Devi;

class DeviVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'devi';
    }

    public function data(): array
    {
        /**  @var Devi $devis */
        $devi = $this->event->getData()['devi'];

        return [
          'id' => $devi->id,
          'ref' => $devi->ref,
        ];

    }

    public function labels(): array
    {
        return [
            'id' => 'id du devis',
            'ref' => 'Réfèrence du devis',
        ];
    }
}

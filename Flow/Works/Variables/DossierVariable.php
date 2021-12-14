<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

class DossierVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'dossier';
    }

    public function data(array $params = []): array
    {
        /** @var \Modules\CoreCRM\Models\Dossier $dossier */
        $dossier = $this->event->getData()['dossier'];

        return [
            'ref' => $dossier->ref,
            'nombre de devis' => $dossier->devis->count(),
            'lien' => route('dossiers.show', [$dossier->client, $dossier])
        ];
    }

    public function labels(): array
    {
        return [
            'ref' => 'Réfèrence du dossier',
            'nombre de devis' => 'Nombre de devis dans le dossier',
            'lien' => 'Lien pour voir le dossier sur le CRM'

        ];
    }
}

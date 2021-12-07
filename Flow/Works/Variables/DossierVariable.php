<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

class DossierVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'dossier';
    }

    public function data(): array
    {
        /** @var \Modules\CoreCRM\Models\Dossier $dossier */
        $dossier = $this->event->getData()['dossier'];

        return [
            'id' => $dossier->id,
            'ref' => $dossier->ref,
            'email commercial' => $dossier->commercial->email,
            'client full name' => $dossier->client->format_name
        ];
    }

    public function labels(): array
    {
        return [
            'id' => 'id du dossier',
            'ref' => 'Réfèrence du dossier',
            'email commercial' => 'Email du commercial accroché au dossier',
            'client full name' => 'Nom et prénom du client'
        ];
    }
}

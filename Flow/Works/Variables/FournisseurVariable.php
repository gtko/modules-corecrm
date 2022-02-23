<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Modules\CoreCRM\Models\Fournisseur;

class FournisseurVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'fournisseur';
    }

    public function data(array $params = []): array
    {
        /**  @var Fournisseur $fournisseur */

        $fournisseur = $this->event->getData()['fournisseur'];

        return [
            'id' => $fournisseur->id,
            'full name' => $fournisseur->format_name,
            'email' => $fournisseur->email,
            'phone' => $fournisseur->phone,
        ];
    }

    public function labels(): array
    {
        return [
            'id' => 'id du fournisseur',
            'full name' => 'Nom et prénom du fournisseur',
            'email' => 'Email du fournisseur',
            'phone' => 'Numéro de téléphone du fournisseur'

        ];
    }
}

<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Illuminate\Support\Str;
use Modules\CoreCRM\Models\Commercial;

class ClientVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'client';
    }

    public function data(array $params = []): array
    {
       /** @var \Modules\CoreCRM\Contracts\Entities\ClientEntity $client */
        $client = $this->event->getData()['client'];

        $genre = $client->personne->gender;
        $salutation = '';
        switch($genre){
            case 'male' :
                $salutation = 'monsieur';
                break;
            case 'female' :
                $salutation = 'madame';
                break;
            default :
                $salutation = 'madame, monsieur';
        }


        return [
          'salutation' => $salutation,
          'salutation avec majuscule' => Str::ucfirst($salutation),
          'email' => $client->email,
          'phone' => $client->phone,
          'nom et prénom' => $client->format_name,
          'adresse' => $client->full_address,
          'lien' => route('clients.show', $client->id),
        ];
    }

    public function labels(): array
    {
        return [
            'salutation' => 'monsieur ou madame ou madame, monsieur',
            'salutation avec majuscule' => 'Monsieur ou Madame ou Madame, monsieur',
            'nom et prénom' => 'Nom et prénom',
            'email' => 'Email',
            'phone' => 'Numéro de téléphone',
            'adresse' => 'Adresse postal',
            'lien' => 'Lien de la fiche du CRM',
        ];
    }
}

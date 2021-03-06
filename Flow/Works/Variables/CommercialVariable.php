<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Models\Commercial;

class CommercialVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'commercial';
    }

    public function data(array $params = []): array
    {
       /** @var Commercial $commercial */
        $user = $this->event->getData()['commercial'];
        $commercial = app(CommercialRepositoryContract::class)->fetchById($user->id);

        return [
          'email' => $commercial->email,
          'phone' => $commercial->phone,
          'avatar' => $commercial->avatar_url,
          'nom et prénom' => $commercial->format_name,
          'nombre de dossier' => $commercial->dossiers()->count(),
          'signature' => <<<mark
            <div>
                $commercial->format_name <br>
                $commercial->email <br>
                $commercial->phone <br>
            </div>
          mark
        ];
    }

    public function labels(): array
    {
        return [
            'nom et prénom' => 'Nom et prénom du commercial',
            'email' => 'Email du commercial',
            'phone' => 'Numéro de téléphone du commercial',
            'avatar' => 'Avatar du commercial',
            'nombre de dossier' => 'Nombre de dossier attribué',
            'signature' => 'Signature du commercial',
        ];
    }
}

<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Modules\CoreCRM\Models\Commercial;

class UserVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'utilisateur';
    }

    public function data(array $params = []): array
    {
       /** @var \Modules\BaseCore\Contracts\Entities\UserEntity $user */
        $user = $this->event->getData()['user'];

        return [
          'email' => $user->email,
          'phone' => $user->phone,
          'avatar' => $user->avatar_url,
          'nom et prénom' => $user->format_name,
          'signature' => <<<mark
            <div>
                $user->format_name <br>
                $user->email <br>
                $user->phone <br>
            </div>
          mark
        ];
    }

    public function labels(): array
    {
        return [
            'nom et prénom' => 'Nom et prénom',
            'email' => 'Email',
            'phone' => 'Numéro de téléphone',
            'avatar' => 'Avatar',
            'signature' => "Signature email de l'utilisateur"
        ];
    }
}

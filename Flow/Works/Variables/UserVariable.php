<?php

namespace Modules\CoreCRM\Flow\Works\Variables;

use Modules\CoreCRM\Models\Commercial;

class UserVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'utilisateur';
    }

    public function data(): array
    {
       /** @var \Modules\BaseCore\Contracts\Entities\UserEntity $user */
        $user = $this->event->getData()['user'];

        return [
          'email' => $user->email,
          'phone' => $user->phone,
          'nom et prénom' => $user->format_name,
        ];
    }

    public function labels(): array
    {
        return [
            'nom et prénom' => 'Nom et prénom',
            'email' => 'Email',
            'phone' => 'Numéro de téléphone',
        ];
    }
}

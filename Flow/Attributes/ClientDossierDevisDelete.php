<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\BaseCore\Models\User;

class ClientDossierDevisDelete extends ClientDossierDevisCreate
{

    public static function instance(array $value): FlowAttributes
    {
        $devis = app(DevisEntities::class)::withTrashed()->find($value['devis_id']);
        $user = app(UserEntity::class)::find($value['user_id']);

        return new ClientDossierDevisDelete($devis, $user);
    }

}

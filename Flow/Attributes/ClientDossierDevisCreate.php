<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\BaseCore\Models\User;

class ClientDossierDevisCreate extends Attributes
{

    public function __construct(
        protected ?DevisEntities $devis,
        protected UserEntity $user
    )
    {
        parent::__construct();
    }

    public static function instance(array $value): FlowAttributes
    {
        $devis = app(DevisEntities::class)::find($value['devis_id']);
        $user = app(UserEntity::class)::find($value['user_id']);

        return new ClientDossierDevisCreate($devis, $user);
    }

    public function toArray(): array
    {
        return [
            'devis_id' => $this->devis->id ?? "",
            'user_id' => $this->user->id
        ];
    }

    public function getDevis():DevisEntities
    {
        return $this->devis ?? "";
    }

    public function getUser():UserEntity
    {
        return $this->user;
    }
}

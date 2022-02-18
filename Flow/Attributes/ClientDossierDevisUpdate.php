<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\BaseCore\Models\User;

class ClientDossierDevisUpdate extends Attributes
{
    public function __construct(
        protected DevisEntities $devis,
        protected UserEntity $user,
        protected array $data
    )
    {
        parent::__construct();
    }

    public static function instance(array $value): FlowAttributes
    {
        $devis = app(DevisEntities::class)::withTrashed()->find($value['devis_id']);
        $user = app(UserEntity::class)::find($value['user_id']);
        $data = $value['data'] ?? [];

        return new ClientDossierDevisUpdate($devis, $user, $data);
    }

    public function toArray(): array
    {
        return [
            'devis_id' => $this->devis->id,
            'user_id' => $this->user->id,
            'data' => $this->data
        ];
    }

    public function getDevis():DevisEntities
    {
        return $this->devis;
    }

    public function getUser():UserEntity
    {
        return $this->user;
    }

    public function getData():array
    {
        return $this->data;
    }
}

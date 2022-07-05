<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\BaseCore\Models\User;

class ClientDossierCreate extends Attributes
{
    protected ?UserEntity $user;

    public function __construct(?UserEntity $user = null)
    {
        parent::__construct();
        $this->user = $user ?? null;
    }

    public static function instance(array $value): FlowAttributes
    {
        $user = app(UserEntity::class)::find($value['user_id']);

        return new ClientDossierCreate($user);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id ?? null
        ];
    }

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

}

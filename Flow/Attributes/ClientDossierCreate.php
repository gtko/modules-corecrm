<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\BaseCore\Models\User;

class ClientDossierCreate extends Attributes
{
    protected UserEntity $user;

    public function __construct(UserEntity $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public static function instance(array $value): FlowAttributes
    {
        $user = app(UserEntity::class)::find($value['user_id']);

        return new ClientDossierCreate($user);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id
        ];
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }

}

<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;

class ClientDossierUpdate extends Attributes
{
    protected UserEntity $user;
    protected string $message;

    public function __construct(UserEntity $user, string $message = '')
    {
        parent::__construct();
        $this->user = $user;
        $this->message = $message;
    }

    public static function instance(array $value): FlowAttributes
    {
        $user = app(UserRepositoryContract::class)->fetchById($value['user_id']);
        return new self($user, $value['message'] ?? '');
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id,
            'message' => $this->message,
        ];
    }

    public function getUser():UserEntity
    {
        return $this->user;
    }

    public function getMessage():string
    {
        return $this->message;
    }
}

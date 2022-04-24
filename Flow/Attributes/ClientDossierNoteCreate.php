<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\BaseCore\Models\User;

class ClientDossierNoteCreate extends Attributes
{

    public function __construct(
        protected UserEntity $user,
        protected string $note
    )
    {
        parent::__construct();
    }

    public function getType(): string
    {
        return static::TYPE_NOTE;
    }

    public static function instance(array $value): FlowAttributes
    {
        $user = app(UserEntity::class)::find($value['user_id']);
        return new ClientDossierNoteCreate($user, $value['note']);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id,
            'note' => $this->note,
        ];
    }

    public function getUser():UserEntity
    {
        return $this->user;
    }

    public function getNote():string
    {
        return $this->note;
    }
}

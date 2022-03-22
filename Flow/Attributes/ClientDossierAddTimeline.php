<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\BaseCore\Models\User;

class ClientDossierAddTimeline extends Attributes
{
    protected ?UserEntity $user;
    protected string $titre;
    protected string $message;

    public function __construct(?UserEntity $user = null, string $titre, string $message)
    {
        parent::__construct();
        $this->user = $user;
        $this->titre = $titre;
        $this->message = $message;
    }

    public static function instance(array $value): FlowAttributes
    {
        $user = app(UserRepositoryContract::class)->fetchById($value['user_id'] ?? 0);
        return app(ClientDossierAddTimeline::class, [
            'user' => $user,
            'titre' => $value['titre'] ?? '',
            'message' => $value['message'] ?? ''
        ]);
    }

    public function toArray(): array
    {
       return [
           'user_id' => $this->user_id ?? null,
           'titre' => $this->titre,
           'message' => $this->message
       ];
    }

    public function getTitre():string
    {
        return $this->titre;
    }

    public function getMessage():string
    {
        return $this->message;
    }

    public function getUser():?UserEntity
    {
        return $this->user;
    }

}

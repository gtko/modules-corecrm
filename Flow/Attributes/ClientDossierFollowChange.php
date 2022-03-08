<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Illuminate\Database\Eloquent\Collection;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;

class ClientDossierFollowChange extends Attributes
{

    protected UserEntity $user;
    protected Collection $followers;

    public function __construct(UserEntity $user, Collection $followers)
    {
        parent::__construct();
        $this->user = $user;
        $this->followers = $followers;
    }

    public static function instance(array $value): FlowAttributes
    {
        $user = app(UserRepositoryContract::class)->fetchById($value['user_id']);
        $followers = app(UserRepositoryContract::class)->newQuery()->whereIn('id', $value['followers'])->get();

        return new self($user, $followers);
    }

    public function toArray(): array
    {
       return [
           'user_id' => $this->user->id,
           'followers' => $this->followers->pluck('id')->toArray()
       ];
    }

    /**
     * @return \Modules\BaseCore\Contracts\Entities\UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }


}

<?php

namespace Modules\CoreCRM\Repositories;



use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Actions\Users\CreateNewTypeUsers;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\BaseCore\Models\Personne;
use Modules\BaseCore\Repositories\AbstractRepository;

class CommercialRepository extends AbstractRepository implements CommercialRepositoryContract
{

    public function getModel(): Model
    {
        return new Commercial();
    }

    public function create(Personne $personne): Commercial
    {
        $user = (new CreateNewTypeUsers())->createNewType($personne, 'commercial');

        return Commercial::find($user->id);
    }


    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return app(UserRepositoryContract::class)->searchQuery($query, $value);
    }

    public function getById(int $id): Commercial
    {
        return Commercial::find($id);
    }
}

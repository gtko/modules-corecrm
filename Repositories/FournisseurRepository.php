<?php namespace Modules\CoreCRM\Repositories;




use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\BaseCore\Actions\Users\CreateNewTypeUsers;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\BaseCore\Models\Personne;

class FournisseurRepository extends AbstractRepository implements FournisseurRepositoryContract
{

    public function create(Personne $personne, $data = []): Fournisseur
    {
        $user = (new CreateNewTypeUsers())->createNewType($personne, 'fournisseur', $data);

        return Fournisseur::find($user->id);
    }


    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return app(UserRepositoryContract::class)->searchQuery($query, $value, $parent)
            ->role('fournisseur');
    }


    public function getModel(): Model
    {
        return new Fournisseur();
    }

    public function getAllList() : Collection
    {
        return $this->newQuery()->get();
    }
}

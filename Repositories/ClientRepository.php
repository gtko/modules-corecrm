<?php namespace Modules\CoreCRM\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\BaseCore\Contracts\Repositories\PersonneRepositoryContract;
use Modules\BaseCore\Helpers\HasInterface;
use Modules\CoreCRM\Models\Client;
use Modules\BaseCore\Models\Personne;
use Modules\CoreCRM\Models\Commercial;
use phpDocumentor\Reflection\Types\Collection;

class ClientRepository extends AbstractRepository implements ClientRepositoryContract
{
    public function createClient(Personne $personne): ?Client
    {
        $client = new Client();
        $client->personne()->associate($personne);
        $client->save();

        return $client;
    }


    public function searchQuery(Builder $query, string $value, mixed $parent = null):Builder
    {
        if(!HasInterface::has(PersonneRepositoryContract::class, $parent)) {
            $query->whereHas('personne', function ($query) use ($value) {
                return app(PersonneRepositoryContract::class)->searchQuery($query, $value, $this);
            });
        }

//        if(!HasInterface::has(DossierRepositoryContract::class, $parent)) {
//            $query->orWhereHas('dossiers', function ($query) use ($value) {
//                return app(DossierRepositoryContract::class)->searchQuery($query, $value, $this);
//            });
//        }


        $query = $this->searchDates($query, $value);

        return $query;
    }

    public function sortBy(Builder $query, string $field, string $order = 'asc'):Builder
    {
        return $query->orderBy($field , $order);
    }

    public function getModel(): Model
    {
       return new Client();
    }

}

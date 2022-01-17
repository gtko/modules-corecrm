<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Modules\BaseCore\Contracts\Repositories\RelationsRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Commercial;
use Modules\BaseCore\Models\Personne;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface CommercialRepositoryContract extends SearchableRepository,RepositoryFetchable, RelationsRepositoryContract
{
    public function create(Personne $personne):Commercial;
    public function getDossiers(Commercial $commmercial): Collection;
    public function getClients(Commercial $commmercial): Collection;
    public function countClientByDays(Commercial $commercial): int;
    public function countClientByMounth(Commercial $commercial): int;
    public function getById(int $id):Commercial;

}

<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Modules\BaseCore\Contracts\Repositories\RelationsRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Commercial;
use Modules\BaseCore\Models\Personne;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface CommercialRepositoryContract extends SearchableRepository,RepositoryFetchable, RelationsRepositoryContract
{
    public function create(Personne $personne):Commercial;

    public function getById(int $id):Commercial;

}

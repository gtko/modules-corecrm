<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Modules\BaseCore\Contracts\Repositories\RelationsRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CoreCRM\Models\Client;
use Modules\BaseCore\Models\Personne;
use Modules\CoreCRM\Models\Commercial;
use Modules\SearchCRM\Interfaces\SearchableRepository;
use phpDocumentor\Reflection\Types\Collection;

interface ClientRepositoryContract extends  SearchableRepository, RepositoryFetchable, RepositoryQueryCustom, RelationsRepositoryContract
{
    public function createClient(Personne $personne):?Client;
}

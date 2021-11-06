<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CoreCRM\Models\Client;
use Modules\BaseCore\Models\Personne;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface ClientRepositoryContract extends  SearchableRepository, RepositoryFetchable, RepositoryQueryCustom
{
    public function createClient(Personne $personne):?Client;
}

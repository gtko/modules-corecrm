<?php


namespace Modules\CoreCRM\Contracts\Repositories;



use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\BaseCore\Models\Personne;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface FournisseurRepositoryContract extends SearchableRepository,RepositoryFetchable
{
    public function create(Personne $personne):Fournisseur;

}

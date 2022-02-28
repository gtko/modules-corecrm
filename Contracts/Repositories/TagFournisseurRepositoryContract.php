<?php


namespace Modules\CoreCRM\Contracts\Repositories;



use Illuminate\Database\Eloquent\Collection;
use Modules\BaseCore\Contracts\Repositories\RelationsRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\BaseCore\Models\Personne;
use Modules\CoreCRM\Models\Tagfournisseur;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface TagFournisseurRepositoryContract extends SearchableRepository, RepositoryFetchable, RelationsRepositoryContract
{
    public function create($name):Tagfournisseur;
}

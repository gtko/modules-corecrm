<?php

namespace Modules\CoreCRM\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreCRM\Models\Tagfournisseur;

class TagFournisseurRepository extends \Modules\BaseCore\Repositories\AbstractRepository implements \Modules\CoreCRM\Contracts\Repositories\TagFournisseurRepositoryContract
{

    public function getModel(): Model
    {
        return new Tagfournisseur();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }

    public function create($name): Tagfournisseur
    {
        return Tagfournisseur::create([
            'name' => $name,
        ]);
    }
}

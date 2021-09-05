<?php

namespace Modules\CoreCRM\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;
use Modules\CoreCRM\Models\Source;

class SourceRepository extends AbstractRepository implements SourceRepositoryContract
{
    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query->where('label', 'LIKE', "%$value%");
    }

    public function create(string $label): Source
    {
        return Source::create(['label' => $label]);
    }

    public function update(Source $source, string $label): Source
    {
        $source->label = $label;
        $source->save();

        return $source;
    }

    public function getModel(): Model
    {
       return new Source();
    }

    public function getByLabel(string $label): Source
    {
        return Source::where('label', $label)->first();
    }

    public function getById(int $id): Source
    {
        return Source::find($id);
    }
}

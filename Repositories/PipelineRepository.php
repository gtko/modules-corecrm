<?php

namespace Modules\CoreCRM\Repositories;

use App\Models\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Pipeline;

class PipelineRepository extends AbstractRepository implements PipelineRepositoryContract
{

    public function getModel(): Model
    {
        return new Pipeline();
    }

    public function create(string $name)
    {
        $pipeline = Pipeline::create(['name' => $name]);

        $statusRep = app(StatusRepositoryContract::class);
        $statusRep->create($pipeline, 'new', 'blue',0, StatusTypeEnum::TYPE_NEW);
        $statusRep->create($pipeline, 'win', 'green',900,StatusTypeEnum::TYPE_WIN);
        $statusRep->create($pipeline, 'lost', 'red',901,StatusTypeEnum::TYPE_LOST);

        return $pipeline;
    }

    public function updateName(Pipeline $pipeline, string $name)
    {
        $pipeline->update(['name' => $name]);

        return $pipeline;
    }

    public function isDefault(Pipeline $pipeline)
    {
        $pipeline->update(['is_default' => true]);
    }

    public function notIsDefault(Pipeline $pipeline)
    {
        $pipeline->update(['is_default' => false]);
    }

    public function all(): Collection
    {
        return Pipeline::all();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
       return $query->where('name', 'LIKE', "%$value%");
    }
}

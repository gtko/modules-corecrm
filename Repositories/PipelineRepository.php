<?php

namespace Modules\CoreCRM\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Status;

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
        $statusRep->create($pipeline, 'new', 'blue',-100, StatusTypeEnum::TYPE_NEW);
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

    public function getDefault(): ?Pipeline
    {
        return Pipeline::where('is_default', 1)->first();
    }

    public function getStatusNew(Pipeline $pipeline): ?Status
    {
        return $pipeline->statuses->where('type', StatusTypeEnum::TYPE_NEW)->first();
    }

    public function updateStatus(Pipeline $pipeline, \Illuminate\Database\Eloquent\Collection|array|\Illuminate\Support\Collection $status)
    {
        $statuses = $pipeline->statuses;
        $status = collect($status);
        $statsRep = app(StatusRepositoryContract::class);
        DB::beginTransaction();
        foreach($statuses as $statuse){
            $newStatus = $status->where('id', $statuse->id)->first();
            if($newStatus){
                $statsRep->update($statuse, $newStatus['label'], $newStatus['color'], $newStatus['order'], $newStatus['type']);
            }else{
                $statuse->dossiers()->update(['status_id' => $status->first()['id']]);
                $statuse->delete();
            }
        }
        DB::commit();

    }
}

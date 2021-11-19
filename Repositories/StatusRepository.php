<?php

namespace Modules\CoreCRM\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Status;

class StatusRepository extends AbstractRepository implements StatusRepositoryContract
{
    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query->where('label', 'LIKE', "%$value%");
    }

    public function create(Pipeline $pipeline, string $label, string $color,int $order, string $type): Status
    {
        return Status::create([
            'label' => $label,
            'color' => $color,
            'order' => $order,
            'type' => $type,
            'pipeline_id' => $pipeline->id
        ]);
    }

    public function update(Status $status, string $label, string $color,int $order, string $type): Status
    {
        $status->label = $label;
        $status->color = $color;
        $status->order = $color;
        $status->type = $color;
        $status->save();

        return $status;
    }

    public function getModel(): Model
    {
        return new Status();
    }

    public function existByLabel(string $label): bool
    {
        return Status::where('label', $label)->exists();
    }

    public function findByLabel(string $label): ?Status
    {
        return Status::where('label', $label)->first();
    }

    public function getById(int $id): Status
    {
       return Status::find($id);
    }

    public function changePipeline(Status $status, Pipeline $pipeline): Status
    {
        $status->pipeline_id = $pipeline->id;
        $status->save();

        return $status;
    }

    public function updateOrder(Status $status, int $order): Status
    {
        $status->order = $order;
        $status->save();

        return $status;
    }

    public function delete(Status $status): bool
    {
        DB::beginTransaction();
        //on deplace tout les dossiers du status dans le new de la pipeline;
        $pipeline = $status->pipeline;
        $newStatus = $pipeline->statuses->where('order', '<', $status->order)->sortByDesc('order')->first();
        //mass update dossier status_id
        Dossier::where('status_id',$status->id)->update(['status_id' => $newStatus->id]);

        //on delete le status
        $good = $status->delete();

        DB::commit();

        return $good;
    }
}

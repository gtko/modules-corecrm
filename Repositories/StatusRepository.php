<?php

namespace Modules\CoreCRM\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Models\Status;

class StatusRepository extends AbstractRepository implements StatusRepositoryContract
{
    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query->where('label', 'LIKE', "%$value%");
    }

    public function create(string $label, string $color): Status
    {
        return Status::create(['label' => $label, 'color' => $color]);
    }

    public function update(Status $status, string $label, string $color): Status
    {
        $status->label = $label;
        $status->color = $color;
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
}

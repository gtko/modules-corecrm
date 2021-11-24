<?php

namespace Modules\CoreCRM\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Repositories\WorkflowRepositoryContract;
use Modules\CoreCRM\Models\Workflow;

class WorkflowRepository extends AbstractRepository implements WorkflowRepositoryContract
{

    public function getModel(): Model
    {
        return new Workflow();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query->where('name', 'LIKE', '%' . $value . '%');
    }

    public function create(string $name, string $description = '', array $events = [], array $conditions = [], array $actions = [], bool $active = false): Workflow
    {
        return Workflow::create([
           'name' => $name,
           'description' => $description,
           'events' => $events,
           'conditions' => $conditions,
           'actions' => $actions,
           'active' => $active
        ]);
    }

    public function update(Workflow $workflow, string $name, string $description = '', array $events = [], array $conditions = [], array $actions = [], bool $active = false): Workflow
    {
        $workflow->update([
            'name' => $name,
            'description' => $description,
            'events' => $events,
            'conditions' => $conditions,
            'actions' => $actions,
            'active' => $active
        ]);

        return $workflow;
    }

    public function updateEvents(Workflow $workflow, array $events): Workflow
    {
        $workflow->update([
            'events' => $events,
        ]);

        return $workflow;
    }

    public function updateConditions(Workflow $workflow, array $conditions): Workflow
    {
        $workflow->update([
            'conditions' => $conditions,
        ]);

        return $workflow;
    }

    public function updateActions(Workflow $workflow, array $actions): Workflow
    {
        $workflow->update([
            'actions' => $actions,
        ]);

        return $workflow;
    }

    public function activate(Workflow $workflow): Workflow
    {
        $workflow->update([
            'active' => true,
        ]);

        return $workflow;
    }

    public function desactivate(Workflow $workflow): Workflow
    {
        $workflow->update([
            'active' => false,
        ]);

        return $workflow;
    }
}
